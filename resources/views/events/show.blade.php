<x-app-layout>
    <x-slot name="header">
        {{-- Título del encabezado de la página de detalles del evento. --}}
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detalles del Evento') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-black text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Contenedor principal con ancho limitado. --}}
            {{-- Enlace para volver a la página de exploración de eventos. --}}
            <a href="{{ route('events.explore') }}" class="text-red-600 hover:underline mb-6 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Volver a Explorar Eventos
            </a>

            {{-- Contenedor principal del contenido del evento. --}}
            <div class="bg-gray-900 rounded-lg shadow-2xl p-8 mt-4 border border-red-600/30">
                <div class="md:flex md:space-x-8 items-start"> {{-- Layout para la imagen y los detalles. --}}
                    <div class="md:w-1/2 mb-6 md:mb-0 flex justify-center"> {{-- Contenedor para la imagen del póster. --}}
                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                             alt="{{ $event->name ?? 'Imagen del evento' }}"
                             class="w-full h-auto rounded-lg shadow-md object-cover max-h-96"
                             >
                    </div>
                    <div class="md:w-1/2 text-center md:text-left"> {{-- Contenedor para la información del evento. --}}
                        {{-- Nombre del evento. --}}
                        <h1 class="text-4xl font-bold text-red-600 mb-4">{{ $event->name }}</h1>
                        {{-- Descripción del evento. --}}
                        <p class="text-lg text-gray-300 mb-4">{{ $event->description }}</p>

                        {{-- Detalles del evento (fecha, lugar, ciudad, categoría, organizador). --}}
                        <div class="space-y-2 mb-6">
                            <p class="text-md text-gray-400">
                                <span class="font-semibold text-white">Fecha:</span>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}
                                @if ($event->end_date)
                                    - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}
                                @endif
                            </p>
                            <p class="text-md text-gray-400"><span class="font-semibold text-white">Lugar:</span> {{ $event->location }}</p>
                            @if ($event->city)
                                <p class="text-md text-gray-400"><span class="font-semibold text-white">Ciudad:</span> {{ $event->city }}</p>
                            @endif
                            <p class="text-md text-gray-400"><span class="font-semibold text-white">Categoría:</span> {{ $event->category->name ?? 'N/A' }}</p>
                            <p class="text-md text-gray-400"><span class="font-semibold text-white">Organizador:</span> {{ $event->user->name ?? 'Desconocido' }}</p>
                        </div>

                        {{-- Información de precio y tickets disponibles. --}}
                        <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between mb-6 space-y-4 sm:space-y-0">
                            <p class="text-3xl font-bold text-red-500">€{{ number_format($event->price, 2) }}</p>
                            @if ($event->available_tickets !== null)
                                <p class="text-lg text-gray-300">Tickets Disponibles: <span id="available-tickets" class="font-bold">{{ $event->available_tickets }}</span></p>
                            @endif
                        </div>

                        {{-- Botón de compra o mensaje de entradas agotadas. --}}
                        @if ($event->available_tickets > 0)
                            <button id="buy-ticket-btn" class="w-full bg-red-600 text-white text-center py-3 px-6 rounded-md hover:bg-red-700 transition duration-300 text-xl font-bold pulse-btn">
                                ¡Comprar Entrada!
                            </button>
                        @else
                            <p class="w-full bg-gray-700 text-white text-center py-3 px-6 rounded-md text-xl font-bold opacity-75 cursor-not-allowed">
                                ¡Entradas Agotadas!
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Simulación de Pago --}}
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-gray-900 border border-red-600/50 rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 p-6 relative animate-fade-in">
            {{-- Botón para cerrar el modal. --}}
            <button id="close-modal-btn" class="absolute top-4 right-4 text-gray-400 hover:text-white text-2xl">&times;</button>

            {{-- Título dinámico del modal. --}}
            <h3 id="modal-title" class="text-2xl font-bold text-white mb-6 text-center">Compra de entrada</h3>

            {{-- Paso 1: Selección de Método de Pago --}}
            <div id="payment-step-1" class="payment-step">
                <p class="text-gray-300 mb-4 text-center">Selecciona tu método de pago:</p>
                <div class="space-y-4">
                    {{-- Botón para pago con tarjeta. --}}
                    <button class="w-full bg-gray-800 text-white py-3 rounded-md flex items-center justify-center space-x-2 hover:bg-gray-700 transition duration-200" data-method="card">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        <span>Tarjeta de Crédito / Débito</span>
                    </button>
                    {{-- Botón para pago con PayPal. --}}
                    <button class="w-full bg-gray-800 text-white py-3 rounded-md flex items-center justify-center space-x-2 hover:bg-gray-700 transition duration-200" data-method="paypal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 7.712l-7.796 7.796a1 1 0 01-1.414 0l-3.898-3.898a1 1 0 010-1.414l7.796-7.796a1 1 0 011.414 0l3.898 3.898a1 1 0 010 1.414z" /></svg>
                        <span>PayPal</span>
                    </button>
                </div>
            </div>

            {{-- Paso 2: Detalles de Pago (Tarjeta) --}}
            <div id="payment-step-2-card" class="payment-step hidden">
                <p class="text-gray-300 mb-4 text-center">Introduce los detalles de tu tarjeta:</p>
                <div class="space-y-4">
                    <div>
                        <label for="card-number" class="block text-gray-400 text-sm font-bold mb-2">Número de Tarjeta</label>
                        <input type="text" id="card-number" class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 bg-gray-800 text-white leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" placeholder="XXXX XXXX XXXX XXXX" maxlength="19">
                    </div>
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label for="expiry-date" class="block text-gray-400 text-sm font-bold mb-2">Fecha de Caducidad</label>
                            <input type="text" id="expiry-date" class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 bg-gray-800 text-white leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" placeholder="MM/AA" maxlength="5">
                        </div>
                        <div class="w-1/2">
                            <label for="cvv" class="block text-gray-400 text-sm font-bold mb-2">CVV</label>
                            <input type="text" id="cvv" class="shadow appearance-none border border-gray-700 rounded w-full py-2 px-3 bg-gray-800 text-white leading-tight focus:outline-none focus:shadow-outline focus:border-red-500" placeholder="XXX" maxlength="4">
                        </div>
                    </div>
                    {{-- Botón para procesar el pago con tarjeta. --}}
                    <button id="process-card-btn" class="w-full bg-red-600 text-white py-3 rounded-md hover:bg-red-700 transition duration-300 font-bold">Pagar con Tarjeta</button>
                </div>
            </div>

            {{-- Paso 2: Detalles de Pago (PayPal) --}}
            <div id="payment-step-2-paypal" class="payment-step hidden">
                <p class="text-gray-300 mb-4 text-center">Serás redirigido a PayPal para completar tu compra.</p>
                {{-- Botón para continuar con PayPal. --}}
                <button id="process-paypal-btn" class="w-full bg-red-600 text-white py-3 rounded-md hover:bg-red-700 transition duration-300 font-bold">Continuar con PayPal</button>
            </div>

            {{-- Paso 3: Procesando Pago --}}
            <div id="payment-step-3" class="payment-step hidden text-center">
                {{-- Loader de animación. --}}
                <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-24 w-24 mx-auto mb-6"></div>
                {{-- Mensaje de procesamiento. --}}
                <p class="text-xl text-white animate-pulse">Procesando tu pago...</p>
            </div>

            {{-- Paso 4: Confirmación de Compra --}}
            <div id="payment-step-4" class="payment-step hidden text-center">
                {{-- Icono de éxito. --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-green-500 mx-auto mb-6 animate-bounce-in" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{-- Mensaje de compra exitosa. --}}
                <h3 class="text-3xl font-bold text-green-500 mb-4 glitch-text">¡Compra Exitosa!</h3>
                {{-- Confirmación de la entrada. --}}
                <p class="text-lg text-gray-300 mb-2">Tu entrada para <span class="font-semibold text-white">{{ $event->name }}</span> ha sido confirmada.</p>
                {{-- ID de la entrada generada. --}}
                <p class="text-gray-400 text-sm mb-6">ID de tu entrada: <span id="ticket-id" class="font-mono text-white text-lg"></span></p>
                {{-- Botón para ir a "Mis Entradas". --}}
                <button id="finish-purchase-btn" class="w-full bg-red-600 text-white py-3 rounded-md hover:bg-red-700 transition duration-300 font-bold">Ver Mis Entradas</button> 
            </div>

            {{-- Paso 5: Mensaje de Error --}}
            <div id="payment-step-error" class="payment-step hidden text-center">
                {{-- Icono de error. --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-red-500 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{-- Título de error. --}}
                <h3 class="text-3xl font-bold text-red-500 mb-4">¡Error en la Compra!</h3>
                {{-- Mensaje de error dinámico. --}}
                <p id="error-message" class="text-lg text-gray-300 mb-6">Ha ocurrido un error al procesar tu compra. Por favor, inténtalo de nuevo.</p>
                {{-- Botón para reintentar la compra. --}}
                <button id="retry-purchase-btn" class="w-full bg-red-600 text-white py-3 rounded-md hover:bg-red-700 transition duration-300 font-bold">Reintentar</button>
            </div>
        </div>
    </div>

    <style>
        /* Estilos CSS para la animación del loader. */
        .loader {
            border-top-color: #ef4444; 
            -webkit-animation: spinner 1.2s linear infinite;
            animation: spinner 1.2s linear infinite;
        }
        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos CSS para la animación del checkmark de éxito. */
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80%, 100% {
                -webkit-animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }
            0% {
                opacity: 0;
                -webkit-transform: scale3d(0.3, 0.3, 0.3);
                transform: scale3d(0.3, 0.3, 0.3);
            }
            20% {
                -webkit-transform: scale3d(1.1, 1.1, 1.1);
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                -webkit-transform: scale3d(0.9, 0.9, 0.9);
                transform: scale3d(0.9, 0.9, 0.9);
            }
            60% {
                opacity: 1;
                -webkit-transform: scale3d(1.03, 1.03, 1.03);
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                -webkit-transform: scale3d(0.97, 0.97, 0.97);
                transform: scale3d(0.97, 0.97, 0.97);
            }
            100% {
                opacity: 1;
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
            }
        }
        .animate-bounce-in {
            animation: bounceIn 0.8s;
        }

        /* Estilos CSS para la animación de fade-in del modal. */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtención de referencias a elementos del DOM.
            const buyTicketBtn = document.getElementById('buy-ticket-btn');
            const paymentModal = document.getElementById('payment-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const modalTitle = document.getElementById('modal-title');
            const availableTicketsSpan = document.getElementById('available-tickets');
            const ticketIdSpan = document.getElementById('ticket-id');
            const finishPurchaseBtn = document.getElementById('finish-purchase-btn');
            const errorMessageSpan = document.getElementById('error-message');
            const retryPurchaseBtn = document.getElementById('retry-purchase-btn');

            const paymentSteps = document.querySelectorAll('.payment-step');
            const paymentStep1 = document.getElementById('payment-step-1');
            const paymentStep2Card = document.getElementById('payment-step-2-card');
            const paymentStep2Paypal = document.getElementById('payment-step-2-paypal');
            const paymentStep3 = document.getElementById('payment-step-3');
            const paymentStep4 = document.getElementById('payment-step-4');
            const paymentStepError = document.getElementById('payment-step-error');

            const cardMethodBtn = paymentStep1.querySelector('[data-method="card"]');
            const paypalMethodBtn = paymentStep1.querySelector('[data-method="paypal"]');
            const processCardBtn = document.getElementById('process-card-btn');
            const processPaypalBtn = document.getElementById('process-paypal-btn');

            // Obtención del token CSRF y el slug del evento.
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const eventSlug = "{{ $event->slug }}";

            let selectedPaymentMethod = '';

            // Función para mostrar un paso específico del modal.
            function showStep(stepToShow) {
                paymentSteps.forEach(step => step.classList.add('hidden'));
                stepToShow.classList.remove('hidden');
            }

            // Event listener para el botón "Comprar Entrada".
            if (buyTicketBtn) {
                buyTicketBtn.addEventListener('click', function() {
                    paymentModal.classList.remove('hidden');
                    modalTitle.textContent = 'Simulación de Compra';
                    showStep(paymentStep1);
                });
            }

            // Event listener para el botón de cerrar modal.
            closeModalBtn.addEventListener('click', function() {
                paymentModal.classList.add('hidden');
                modalTitle.textContent = 'Simulación de Compra';
                showStep(paymentStep1);
                errorMessageSpan.textContent = 'Ha ocurrido un error al procesar tu compra. Por favor, inténtalo de nuevo.';
            });

            // Event listener para seleccionar el método de pago con tarjeta.
            cardMethodBtn.addEventListener('click', function() {
                selectedPaymentMethod = 'card';
                modalTitle.textContent = 'Detalles de Tarjeta';
                showStep(paymentStep2Card);
            });

            // Event listener para seleccionar el método de pago con PayPal.
            paypalMethodBtn.addEventListener('click', function() {
                selectedPaymentMethod = 'paypal';
                modalTitle.textContent = 'Redirigiendo a PayPal';
                showStep(paymentStep2Paypal);
            });

            // Event listener para procesar el pago con tarjeta.
            processCardBtn.addEventListener('click', function() {
                const cardNumber = document.getElementById('card-number').value;
                const expiryDate = document.getElementById('expiry-date').value;
                const cvv = document.getElementById('cvv').value;

                // Validación simple de los campos de tarjeta.
                if (cardNumber.length < 16 || expiryDate.length < 5 || cvv.length < 3) {
                    errorMessageSpan.textContent = 'Por favor, rellena todos los campos de la tarjeta.';
                    showStep(paymentStepError);
                    return;
                }

                modalTitle.textContent = 'Procesando...';
                showStep(paymentStep3);
                processPurchase(selectedPaymentMethod);
            });

            // Event listener para procesar el pago con PayPal.
            processPaypalBtn.addEventListener('click', function() {
                modalTitle.textContent = 'Procesando...';
                showStep(paymentStep3);
                processPurchase(selectedPaymentMethod);
            });

            // Función asíncrona para procesar la compra.
            async function processPurchase(method) {
                try {
                    // Envío de la solicitud de compra al servidor.
                    const response = await fetch("{{ route('events.purchase', $event->slug) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            payment_method: method,
                        })
                    });

                    const data = await response.json();

                    // Manejo de la respuesta del servidor.
                    if (response.ok) {
                        modalTitle.textContent = '¡Compra Exitosa!';
                        ticketIdSpan.textContent = data.ticket_code;
                        availableTicketsSpan.textContent = data.new_tickets_available;

                        showStep(paymentStep4);

                        // Actualiza el estado del botón de compra si los tickets se agotan.
                        if (data.new_tickets_available === 0) {
                            if (buyTicketBtn) {
                                buyTicketBtn.disabled = true;
                                buyTicketBtn.classList.remove('bg-red-600', 'hover:bg-red-700', 'pulse-btn');
                                buyTicketBtn.classList.add('bg-gray-700', 'opacity-75', 'cursor-not-allowed');
                                buyTicketBtn.textContent = '¡Entradas Agotadas!';
                            }
                        }

                        // Redirige al usuario después de unos segundos.
                        setTimeout(() => {
                            window.location.href = "{{ route('my-tickets.index') }}";
                        }, 3000);

                    } else {
                        // Muestra el mensaje de error si la compra falla.
                        modalTitle.textContent = '¡Error!';
                        errorMessageSpan.textContent = data.message || 'Ha ocurrido un error inesperado al procesar la compra.';
                        showStep(paymentStepError);
                    }

                } catch (error) {
                    // Captura y maneja errores de conexión.
                    console.error('Error en la solicitud de compra:', error);
                    modalTitle.textContent = '¡Error!';
                    errorMessageSpan.textContent = 'Error de conexión. Por favor, inténtalo de nuevo más tarde.';
                    showStep(paymentStepError);
                }   
            }

            // Event listener para el botón "Ver Mis Entradas".
            finishPurchaseBtn.addEventListener('click', function() {
                window.location.href = "{{ route('my-tickets.index') }}";
            });

            // Event listener para el botón "Reintentar".
            retryPurchaseBtn.addEventListener('click', function() {
                modalTitle.textContent = 'Simulación de Compra';
                showStep(paymentStep1);
                errorMessageSpan.textContent = 'Ha ocurrido un error al procesar tu compra. Por favor, inténtalo de nuevo.';
            });
        });
    </script>
</x-app-layout>