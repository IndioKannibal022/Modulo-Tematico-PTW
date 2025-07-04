<x-layout>
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i data-lucide="tag" class="h-6 w-6 text-primary mr-2"></i>
            <h1 class="text-2xl font-bold text-text">Anunciar Produto</h1>
        </div>

        <div class="bg-blue-50 border-l-4 border-primary p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <i data-lucide="info" class="h-5 w-5 text-primary mr-2"></i>
                <div>
                    <p class="text-sm text-primary-600">Anuncie seu jogo ou console em poucos passos. Produtos com fotos
                        de qualidade vendem até 3x mais rápido!</p>
                </div>
            </div>
        </div>

        <!-- Seletor de tipo de produto -->
        <div class="mb-6">
            <label class="block text-text font-medium mb-2">Tipo de Produto</label>
            <select id="tipo-produto" name="tipo_produto"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="jogo" selected>Jogo</option>
                <option value="console">Console</option>
            </select>
        </div>

        <!-- Formulário de JOGO -->
        <form id="form-jogo" class="space-y-6" action="{{ route('jogo.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <!-- Token CSRF obrigatório para segurança -->

            @if ($errors->has('erro'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r-lg">
                    <p>{{ $errors->first('erro') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Product Photos -->
            <div class="mb-12">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="gameImages"
                >
                    Adicionar imagens dos jogos
                </label>
                <div class="flex items-center space-x-3 mt-2">
                    <!-- Botão de adicionar imagens -->
                    <label
                        for="gameImages"
                        class="w-24 h-24 flex items-center justify-center rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 cursor-pointer hover:bg-gray-200"
                    >
                        <span class="text-gray-400 font-bold text-4xl">+</span>
                    </label>
                    <input
                        id="gameImages"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        name="imagens[]"
                        multiple
                    />
                    <!-- Contêiner para os previews -->
                    <div
                        id="imagePreviewContainer"
                        class="grid grid-cols-6 gap-4"
                    >
                        <!-- Previews das imagens aparecerão aqui -->
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <i data-lucide="info" class="h-4 w-4 mr-1"></i>
                    Adicione até 6 fotos do jogo. A primeira será a capa do anúncio.
                </p>
            </div>

            <!-- Product Name -->
            <div>
                <label for="product-name" class="block text-text font-medium mb-2">Nome do Produto</label>
                <input type="text" id="product-name" name="nome"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                       placeholder="Ex: PlayStation 5"/>
                <p class="text-xs text-gray-500 mt-1">Seja específico. Inclua detalhes como marca, modelo e edição.</p>
            </div>

            <!-- Product Price -->
            <div>
                <label for="product-price" class="block text-text font-medium mb-2">Preço do Produto</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">€</span>
                    </div>
                    <input type="number" id="product-price" name="preco"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="0,00" step="0.01" min="0"/>
                </div>
            </div>

            <!-- Product Condition -->
            <div>
                <label class="block text-text font-medium mb-2">Estado do Produto</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <input type="radio" id="condition-new" name="estado" value="novo" class="hidden peer" checked/>
                        <label for="condition-new"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            <i data-lucide="package" class="h-4 w-4 mr-2"></i>
                            Novo
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="condition-used" name="estado" value="usado" class="hidden peer"/>
                        <label for="condition-used"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            <i data-lucide="package-open" class="h-4 w-4 mr-2"></i>
                            Usado
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="condition-refurbished" name="estado" value="recondicionado"
                               class="hidden peer"/>
                        <label for="condition-refurbished"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            <i data-lucide="package-check" class="h-4 w-4 mr-2"></i>
                            Recondicionado
                        </label>
                    </div>
                </div>
            </div>


            <!-- Game Category -->
            <div>
                <label for="game-category" class="block text-text font-medium mb-2">Categoria de Jogo</label>
                <select id="game-category" name="id_categoria"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="" disabled selected>Selecione uma categoria</option>
                @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Escolha a categoria que melhor descreve seu jogo.</p>
            </div>

            <!-- Região -->
            <div>
                <label for="region" class="block text-text font-medium mb-2">Região</label>
                <input type="text" id="region" name="regiao"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                       placeholder="Ex: America, Europa ou Japão"/>
                <p class="text-xs text-gray-500 mt-1">Informe a localização ou região onde o jogo está disponível.</p>
            </div>


            <!-- Product Description -->
            <div>
                <label for="product-description" class="block text-text font-medium mb-2">Descrição do Produto</label>
                <textarea id="product-description" name="descricao" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                          placeholder="Descreva o produto, mencione detalhes importantes como tempo de uso, acessórios incluídos, etc."></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Seja detalhado e honesto sobre o estado do produto.</p>
                    <p class="text-xs text-gray-500"><span id="char-count">0</span>/1000 caracteres</p>
                </div>
            </div>

            <!-- Console Type -->
            <div>
                <label for="console-type" class="block text-text font-medium mb-2">Tipo de Console</label>
                <select id="console-type" name="console_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="" disabled selected>Selecione uma plataforma</option>
                    @foreach($modelo_consoles as $modelo_console)
                        <option value="{{ $modelo_console->id }}">{{ $modelo_console->nome }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition text-center justify-center flex">
                    Publicar Anúncio
                </button>
            </div>

        </form>

        <!-- Formulário de Console -->
        <form id="form-console" action="{{ route('console.store') }}" method="POST" class="space-y-6"
              style="display:none;" enctype="multipart/form-data">
            @csrf

            @if ($errors->has('erro'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r-lg">
                    <p>{{ $errors->first('erro') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r-lg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif


            <!-- Fotos do Console -->
            <div class="mb-12">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="consoleImages"
                >
                    Adicionar imagens dos consoles
                </label>
                <div class="flex items-center space-x-3 mt-2">
                    <!-- Botão de adicionar imagens -->
                    <label
                        for="consoleImages"
                        class="w-24 h-24 flex items-center justify-center rounded-lg bg-gray-100 border-2 border-dashed border-gray-300 cursor-pointer hover:bg-gray-200"
                    >
                        <span class="text-gray-400 font-bold text-4xl">+</span>
                    </label>
                    <input
                        id="consoleImages"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        name="imagens[]"
                        multiple
                    />
                    <!-- Contêiner para os previews -->
                    <div
                        id="consolePreviewContainer"
                        class="grid grid-cols-6 gap-4"
                    >
                        <!-- Previews das imagens aparecerão aqui -->
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <i data-lucide="info" class="h-4 w-4 mr-1"></i>
                    Adicione até 6 fotos do console. A primeira será a capa do anúncio.
                </p>
            </div>

            <!-- Nome do Console -->
            <div>
                <label for="console-nome" class="block text-text font-medium mb-2">Nome do Console</label>
                <input type="text" id="console-nome" name="nome"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ex: PlayStation 5"/>
                <p class="text-xs text-gray-500 mt-1">Inclua marca, modelo e edição se aplicável.</p>
            </div>

            <!-- Tipo de Console -->
            <div>
                <label for="console-tipo" class="block text-text font-medium mb-2">Tipo de Console</label>
                <select id="console-tipo" name="modelo_console_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"><option value="outro">Outro</option>
                    <option value="" disabled selected>Selecione uma plataforma</option>
                @foreach($modelo_consoles as $modelo_console)
                        <option value="{{ $modelo_console->id }}">{{ $modelo_console->nome }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Preço -->
            <div>
                <label for="console-preco" class="block text-text font-medium mb-2">Preço</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">€</span>
                    </div>
                    <input type="number" id="console-preco" name="preco"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg" placeholder="0,00"
                           step="0.01" min="0"/>
                </div>
            </div>

            <!-- Estado do Console -->
            <div>
                <label class="block text-text font-medium mb-2">Estado do Console</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <input type="radio" id="console-novo" name="estado" value="novo" class="hidden peer"/>
                        <label for="console-novo"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            Novo
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="console-usado" name="estado" value="usado" class="hidden peer"/>
                        <label for="console-usado"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            Usado
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="console-recondicionado" name="estado" value="recondicionado"
                               class="hidden peer"/>
                        <label for="console-recondicionado"
                               class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer text-gray-500 bg-white hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:text-blue-600 peer-checked:bg-white">
                            Recondicionado
                        </label>
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div>
                <label for="console-descricao" class="block text-text font-medium mb-2">Descrição</label>
                <textarea id="console-descricao" name="descricao" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                          placeholder="Descreva o console, acessórios inclusos, estado de conservação, etc."></textarea>
                <div class="flex justify-between mt-1">
                    <p class="text-xs text-gray-500">Seja detalhado e honesto sobre o estado do console.</p>
                    <p class="text-xs text-gray-500"><span id="char-count-console">0</span>/1000 caracteres</p>
                </div>
            </div>


            <!-- Botão de Envio -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                    Publicar Console
                </button>
            </div>


        </form>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const jogoForm = document.getElementById('form-jogo');
            const consoleForm = document.getElementById('form-console');
            const tipoProdutoSelect = document.getElementById('tipo-produto');

            // Seletores do Formulário de Jogo
            const imageInput = document.getElementById("gameImages");
            const previewContainer = document.getElementById("imagePreviewContainer");

            // Seletores do Formulário de Console (ID atualizado)
            const consoleImageInput = document.getElementById("consoleImages");
            const consolePreviewContainer = document.getElementById("consolePreviewContainer");



            function showError(input, message) {
                input.classList.add('border-red-500');
                let errorEl = input.nextElementSibling;
                if (!errorEl || !errorEl.classList.contains('input-error')) {
                    errorEl = document.createElement('p');
                    errorEl.className = 'text-red-500 text-sm mt-1 input-error';
                    input.parentNode.appendChild(errorEl);
                }
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }

            function clearError(input) {
                input.classList.remove('border-red-500');
                const errorEl = input.parentNode.querySelector('.input-error');
                if (errorEl) errorEl.classList.add('hidden');
            }

            function validarDescricao(input, counter) {
                input.addEventListener('input', () => {
                    const count = input.value.length;
                    counter.textContent = count;
                    if (count > 1000) {
                        counter.classList.add('text-red-500');
                        input.classList.add('border-red-500');
                    } else {
                        counter.classList.remove('text-red-500');
                        input.classList.remove('border-red-500');
                    }
                });
            }

            async function validarFormulario(formulario, tipo) {
                let isValid = true;

                const nome = formulario.querySelector('[name="nome"]');
                const preco = formulario.querySelector('[name="preco"]');
                const estado = formulario.querySelector('[name="estado"]:checked');
                const descricao = formulario.querySelector('textarea[name="descricao"]');
                const imagens = formulario.querySelector('input[type="file"]');
                const charCounter = formulario.querySelector('span[id^="char-count"]');
                const categoria = formulario.querySelector('[name="id_categoria"]');
                const consoleTipo = formulario.querySelector('[name="console"]') || formulario.querySelector('[name="tipo_console"]');

                const campos = [nome, preco, descricao, imagens, consoleTipo];
                if (tipo === 'jogo') campos.push(categoria);

                campos.forEach(campo => clearError(campo));

                if (!nome.value.trim()) {
                    showError(nome, "O nome é obrigatório.");
                    isValid = false;
                } else if (nome.value.trim().length < 3) {
                    showError(nome, "O nome deve ter pelo menos 3 caracteres.");
                    isValid = false;
                }

                if (!preco.value || parseFloat(preco.value) <= 0) {
                    showError(preco, "Insira um preço válido.");
                    isValid = false;
                }

                if (!estado) {
                    const label = formulario.querySelector('label[for*="condition"], label[for*="console"]');
                    if (label) showError(label, "Escolha o estado do produto.");
                    isValid = false;
                }

                if (!descricao.value.trim()) {
                    showError(descricao, "A descrição é obrigatória.");
                    isValid = false;
                } else if (descricao.value.length > 1000) {
                    showError(descricao, "Máximo de 1000 caracteres.");
                    isValid = false;
                }

                if (!consoleTipo || !consoleTipo.value) {
                    showError(consoleTipo, "Escolha um tipo de console.");
                    isValid = false;
                }

                if (tipo === 'jogo' && (!categoria || !categoria.value)) {
                    showError(categoria, "Selecione uma categoria.");
                    isValid = false;
                }

                if (!imagens.files || imagens.files.length === 0) {
                    showError(imagens, "Adicione pelo menos uma imagem.");
                    isValid = false;
                }

                return isValid;
            }

            jogoForm.addEventListener('submit', async (e) => {
                const valido = await validarFormulario(jogoForm, 'jogo');
                if (!valido) e.preventDefault();
            });

            consoleForm.addEventListener('submit', async (e) => {
                const valido = await validarFormulario(consoleForm, 'console');
                if (!valido) e.preventDefault();
            });


            tipoProdutoSelect.addEventListener('change', () => {
                if (tipoProdutoSelect.value === 'jogo') {
                    jogoForm.style.display = 'block';
                    consoleForm.style.display = 'none';
                } else if (tipoProdutoSelect.value === 'console') {
                    jogoForm.style.display = 'none';
                    consoleForm.style.display = 'block';
                }
            });

            // Inicializa o estado correto com base no valor padrão
            tipoProdutoSelect.dispatchEvent(new Event('change'));







            // Função para lidar com pré-visualização de imagens
            const handleImageInput = (input, previewContainer, maxFiles = 6) => {
                input.addEventListener("change", () => {
                    clearError(input); // Remove erros anteriores
                    previewContainer.innerHTML = ""; // Limpa os previews antigos

                    const files = Array.from(input.files); // Obtém os arquivos selecionados

                    // Valida o limite de arquivos
                    if (files.length > maxFiles) {
                        showError(input, `Você pode selecionar no máximo ${maxFiles} imagens.`);
                        input.value = ""; // Reseta o campo de seleção
                        return;
                    }

                    // Gera os previews das imagens
                    files.forEach((file) => {
                        if (file.type.startsWith("image/")) {
                            const reader = new FileReader();

                            reader.onload = (e) => {
                                // Criação do contêiner da imagem
                                const imageDiv = document.createElement("div");
                                imageDiv.classList.add(
                                    "relative",
                                    "w-24",
                                    "h-24",
                                    "overflow-hidden",
                                    "rounded-lg",
                                    "shadow-md",
                                    "bg-gray-200"
                                );

                                const img = document.createElement("img");
                                img.src = e.target.result;
                                img.alt = file.name;
                                img.classList.add("object-cover", "w-full", "h-full");

                                imageDiv.appendChild(img);
                                previewContainer.appendChild(imageDiv);
                            };

                            reader.readAsDataURL(file);
                        }
                    });
                });
            };

            // Aplica a função para os inputs e contêineres de jogo e console
            handleImageInput(imageInput, previewContainer); // Jogo
            handleImageInput(consoleImageInput, consolePreviewContainer); // Console







            // descrição tempo real
            validarDescricao(document.getElementById('product-description'), document.getElementById('char-count'));
            validarDescricao(document.getElementById('console-descricao'), document.getElementById('char-count-console'));
        });
    </script>
</x-layout>
