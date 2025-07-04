<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\SetupIntent;
use App\Models\PaymentMethod;

class StripeController extends Controller
{
    /**
     * Cria um SetupIntent para o utilizador autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSetupIntent()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();

        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);

            $user->stripe_customer_id = $customer->id;
            $user->save();
        }

        $intent = SetupIntent::create([
            'customer' => $user->stripe_customer_id,
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
            'stripeKey'    => env('STRIPE_KEY'),
        ]);
    }

    /**
     * Armazena o metodo de pagamento do utilizador autenticado.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePaymentMethod(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();
        $paymentMethodId = $request->input('payment_method');

        // Anexa no Stripe
        \Stripe\PaymentMethod::retrieve($paymentMethodId)
            ->attach(['customer' => $user->stripe_customer_id]);

        // Salva localmente
        $isFirst = $user->paymentMethods()->count() === 0;

        PaymentMethod::create([
            'user_id' => $user->id,
            'stripe_payment_method_id' => $paymentMethodId,
            'is_default' => $isFirst,
        ]);

        return response()->json(['message' => 'Cartão salvo com sucesso!']);
    }

    /**
     * Exibe o formulário para adicionar um novo metodo de pagamento.
     *
     * @return \Illuminate\View\View
     */
    public function storePaymentMethodForm(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();
        $paymentMethod = auth()->user()->paymentMethods();
        $paymentMethodId = $request->input('payment_method');



        if (!$paymentMethodId) {
            return redirect()->back()->withErrors(['payment_method' => 'Falha ao adicionar cartão.']);
        }

        \Stripe\PaymentMethod::retrieve($paymentMethodId)
            ->attach(['customer' => $user->stripe_customer_id]);

        $isFirst = $user->paymentMethods()->count() === 0;

        PaymentMethod::create([
            'nome_cartao' => $request->input('nome_cartao'),
            'user_id' => $user->id,
            'stripe_payment_method_id' => $paymentMethodId,
            'is_default' => $isFirst,
        ]);

        if ($isFirst) {
            \Stripe\Customer::update($user->stripe_customer_id, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId,
                ],
            ]);
        }

        if ($request->has('from') && $request->get('from') === 'checkout') {
            return redirect()->route('checkout.index')->with('success', 'Morada adicionada com sucesso!');
        }

        return redirect()->route('perfilCartoes')->with('success', 'Cartão salvo com sucesso!');
    }

    /**
     * Define um cartão como padrão para o utilizador autenticado.
     *
     * @param int $id ID do metodo de pagamento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefaultCard($id)
    {
        $user = auth()->user();
        $method = PaymentMethod::where('user_id', $user->id)->findOrFail($id);

        PaymentMethod::where('user_id', $user->id)->update(['is_default' => false]);

        \Stripe\Customer::update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $method->stripe_payment_method_id,
            ],
        ]);

        $method->is_default = true;
        $method->save();

        return back()->with('success', 'Cartão padrão atualizado!');
    }

    /**
     * Desativa um cartão de pagamento do utilizador autenticado.
     *
     * @param int $id ID do metodo de pagamento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function desativarCartao($id)
    {
        $user = auth()->user();

        $cartao = $user->paymentMethods()->where('id', $id)->first();

        if (!$cartao) {
            return redirect()->back()->withErrors('Cartão não encontrado ou não pertence a este utilizador.');
        }

        $cartao->ativo = false;
        $cartao->save();

        return redirect()->route('perfilCartoes')->with('success', 'Cartão desativado com sucesso.');
    }

    /**
     * Lista os cartões de pagamento do utilizador autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function listarCartoes()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = auth()->user();
        $cartoesSalvos = $user->paymentMethods->where('ativo',true);

        $cartoesDetalhados = [];

        foreach ($cartoesSalvos as $cartao) {
            $stripeCard = \Stripe\PaymentMethod::retrieve($cartao->stripe_payment_method_id);

            $cartoesDetalhados[] = (object) [
                'id' => $cartao->id,
                'brand' => $stripeCard->card->brand,
                'last4' => $stripeCard->card->last4,
                'exp_month' => $stripeCard->card->exp_month,
                'exp_year' => $stripeCard->card->exp_year,
                'nome_titular' => $stripeCard->billing_details->name,
                'is_default' => $cartao->is_default,
            ];
        }

        return view('paginas.perfil.perfilcartoes', [
            'cartoes' => $cartoesDetalhados
        ]);
    }

    /**
     * Lista os cartões de pagamento para o checkout.
     *
     * @return \Illuminate\View\View
     */
    public function listarCartoesCheckout()
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $user = auth()->user();
        $cartoesSalvos = $user->paymentMethods;

        $cartoesDetalhados = [];

        foreach ($cartoesSalvos as $cartao) {
            $stripeCard = \Stripe\PaymentMethod::retrieve($cartao->stripe_payment_method_id);

            $cartoesDetalhados[] = (object) [
                'id' => $cartao->id,
                'brand' => $stripeCard->card->brand,
                'last4' => $stripeCard->card->last4,
                'exp_month' => $stripeCard->card->exp_month,
                'exp_year' => $stripeCard->card->exp_year,
                'nome_cartao' => $cartao->nome_cartao,
                'is_default' => $cartao->is_default,
            ];
        }

        return view('paginas.checkout', [
            'cartoes' => $cartoesDetalhados
        ]);
    }


}
