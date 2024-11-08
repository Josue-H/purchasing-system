@extends('layouts.app')

@section('content')
        <!-- Carrito de Compras -->
        <div class="container mt-4">
            <div class="text-end">
                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        {{ count($cart) }}
                    </span>
                </button>
            </div>
        </div>
    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Bienvenido</h1>
                <p class="lead fw-normal text-white-50 mb-0">Explora nuestra amplia variedad de productos</p>
            </div>
        </div>
    </header>



<!-- Modal del Carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Detalle del Carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group mb-3" id="cart-items">
                    <!-- Aquí se añadirán los elementos del carrito dinámicamente -->
                </ul>
                <div class="text-end">
                    <strong>Total: Q<span id="cart-total">0</span></strong>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceder al Pago</a>
            </div>
        </div>
    </div>
</div>


    <!-- Productos -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($productos as $producto)
                    <div class="col mb-5">
                        <div class="card h-100 producto-card">
                            <div class="position-relative">
                                <img class="card-img-top" src="{{ asset($producto->imagenUrl) }}" alt="{{ $producto->nombreProducto }}" />
                                <div class="overlay">
                                    <div class="overlay-content text-center">
                                        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                                        <p><strong>En Stock:</strong> {{ $producto->stock }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bolder">{{ $producto->nombreProducto }}</h5>
                                <p class="fw-bold">Q{{ $producto->precio }}</p>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                <button class="btn btn-outline-dark mt-auto add-to-cart" data-id="{{ $producto->idProducto }}" data-csrf="{{ csrf_token() }}">Add to cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Burbuja para abrir el modal del ChatBot -->
<button type="button" id="chatbot-button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chatModal">
    💬
  </button>

  <!-- Modal de ChatBot con apariencia de chat -->
  <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chatModalLabel">Chatbot</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="chat-modal-body">
          <!-- Chatbox donde se muestran los mensajes -->
          <div id="chatbox" class="chatbox"></div>

          <!-- Formulario de chatbot estilo chat -->
          <form id="chat-form" class="chat-form">
            @csrf
            <input type="text" id="message" class="chat-input" placeholder="Escribe un mensaje..." autocomplete="off" />
            <button type="submit" class="chat-send-btn">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- CSS para el estilo del chat -->
  <style>
    /* Burbuja en la esquina inferior izquierda */
    #chatbot-button {
      position: fixed;
      bottom: 20px;
      left: 20px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #007bff;
      color: white;
      font-size: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      z-index: 1050;
      cursor: pointer;
    }

    /* Chat modal estilo chat */
    #chatModal .modal-dialog {
      position: fixed;
      bottom: 90px;
      left: 20px;
      margin: 0;
      max-width: 300px;
    }

    /* Estilo de la ventana de chat */
    .chatbox {
      max-height: 300px;
      overflow-y: auto;
      padding: 10px;
      background-color: #f1f1f1;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    /* Estilo de los mensajes en el chat */
    .chat-message {
      display: flex;
      align-items: center;
      margin: 5px 0;
    }

    .chat-message.user {
      justify-content: flex-end;
    }

    .chat-message.bot {
      justify-content: flex-start;
    }

    .chat-bubble {
      max-width: 80%;
      padding: 10px;
      border-radius: 10px;
      background-color: #7a6235;
      color: white;
      margin: 2px;
    }

    .chat-message.user .chat-bubble {
      background-color: #dcf8c6;
      color: black;
    }

    /* Estilo del formulario de entrada de mensaje */
    .chat-form {
      display: flex;
      border-top: 1px solid #ddd;
      padding-top: 5px;
    }

    .chat-input {
      flex: 1;
      padding: 8px;
      border: none;
      border-radius: 5px;
      margin-right: 5px;
    }

    .chat-send-btn {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 8px 10px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>

  <!-- JavaScript para mostrar el chat y enviar mensajes -->
  <script>
    /*  */

    document.getElementById('chat-form').addEventListener('submit', function (e) {
      e.preventDefault();
      let message = document.getElementById('message').value.trim();

      // No enviar mensajes vacíos
      if (message === '') return;

      // Agregar mensaje del usuario al chatbox
      addMessageToChatbox('user', message);

      // Limpiar el campo de entrada
      document.getElementById('message').value = '';

      // Enviar el mensaje al backend y recibir respuesta
      fetch('/botman', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message })
      })
      .then(response => response.json())
      .then(data => {
        // Agregar respuesta del bot al chatbox
        addMessageToChatbox('bot', data.message);
      })
      .catch(error => console.error("Error en el fetch:", error));
    });

    function addMessageToChatbox(sender, message) {
        const chatbox = document.getElementById('chatbox');
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', sender);

        const bubbleElement = document.createElement('div');
        bubbleElement.classList.add('chat-bubble');
        // Usar innerHTML para interpretar el contenido HTML
        bubbleElement.innerHTML = message;

        messageElement.appendChild(bubbleElement);
        chatbox.appendChild(messageElement);

        // Desplazarse hacia el último mensaje
        chatbox.scrollTop = chatbox.scrollHeight;
    }
  </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Obtener y mostrar el carrito desde la sesión cuando se carga la página
            $.get('/cart/get', function (response) {
                updateCartDisplay(response.cart, response.total);
                $('.badge').text(Object.keys(response.cart).length); // Actualizar la cantidad en el ícono del carrito
            });

            // Función para añadir producto al carrito
            $('.add-to-cart').click(function (e) {
                e.preventDefault();

                const productId = $(this).data('id');

                $.ajax({
                    url: `/cart/add/${productId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('.badge').text(response.cartCount);
                        updateCartDisplay(response.cart, response.total);
                        alert('Producto agregado al carrito');
                    },
                    error: function () {
                        alert('Hubo un problema al agregar el producto al carrito');
                    }
                });
            });

            // Función para actualizar la visualización del carrito en el modal
            function updateCartDisplay(cart, total) {
                $('#cart-items').empty();
                $.each(cart, function (id, producto) {
                    $('#cart-items').append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="${id}">
                            <div>
                                <h6 class="my-0">${producto.nombreProducto}</h6>
                                <small class="text-muted">Cantidad: <span class="cantidad">${producto.cantidad}</span></small>
                            </div>
                            <span class="text-muted precio-total">Q${producto.precio * producto.cantidad}</span>
                            <div class="btn-group ms-3">
                                <button class="btn btn-success btn-sm btn-incrementar" data-id="${id}">+</button>
                                <button class="btn btn-danger btn-sm btn-decrementar" data-id="${id}">-</button>
                                <button class="btn btn-outline-danger btn-sm btn-eliminar" data-id="${id}">Eliminar</button>
                            </div>
                        </li>
                    `);
                });
                $('#cart-total').text(total);
            }

            // Incrementar cantidad
            $(document).on('click', '.btn-incrementar', function (e) {
                e.preventDefault();
                const id = $(this).data('id');

                $.post(`/cart/add/${id}`, {_token: '{{ csrf_token() }}'}, function (response) {
                    $('.badge').text(response.cartCount);
                    updateCartDisplay(response.cart, response.total);
                });
            });

            // Decrementar cantidad
            $(document).on('click', '.btn-decrementar', function (e) {
                e.preventDefault();
                const id = $(this).data('id');

                $.post(`/cart/remove/${id}`, {_token: '{{ csrf_token() }}'}, function (response) {
                    $('.badge').text(response.cartCount);
                    updateCartDisplay(response.cart, response.total);
                });
            });

            // Eliminar producto
            $(document).on('click', '.btn-eliminar', function (e) {
                e.preventDefault();
                const id = $(this).data('id');

                $.post(`/cart/delete/${id}`, {_token: '{{ csrf_token() }}'}, function (response) {
                    $('.badge').text(response.cartCount);
                    updateCartDisplay(response.cart, response.total);
                });
            });
        });
    </script>



    <style>
        .producto-card {
            overflow: hidden;
            cursor: pointer;
        }
        .position-relative {
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .position-relative:hover .overlay {
            opacity: 1;
        }
        .overlay-content {
            padding: 10px;
        }
    </style>
@endsection
