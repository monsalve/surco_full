
    @include('header')
    
    

    <div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url('img/bg_1.jpg')">
        <div class="container">
          <div class="row align-items-end">
            <div class="col-lg-7">
              <h2 class="mb-0">Cursos</h2>
              <p>Conoce nuestra oferta academica.</p>
            </div>
          </div>
        </div>
      </div> 
    

    <div class="custom-breadcrumns border-bottom">
      <div class="container">
        <a href="/">Inicio</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">Cursos</span>
      </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
              @foreach ($cursos as $curso)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="course-1-item">
                        <figure class="thumnail">
                        <a href="/detalle/{{ $curso->id}}"><img src="img/{{$curso->img}}" alt="Image" class="img-fluid"></a>
                        <div style="background: #d86a0b;" class="price">$ {{number_format($curso->valor,0)}}</div>
                        <div class="category"><h3>Categoria: </h3>{{$categorias[$curso->categoria]}}</div>  
                        </figure>
                        <div class="course-1-content pb-4">
                          @if ($curso->tipo == 1)
                            <h3>Curso de capacitación en</h3>
                          @else
                            <h2>Diplomado en</h2>
                          @endif
                          <h3>{{$curso->nombre}}</h3>
                        <!--
                        <div class="rating text-center mb-3">
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                            <span class="icon-star2 text-warning"></span>
                        </div>
                        <p class="desc mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique accusantium ipsam.</p>-->
                        <p><a href="/detalle" class="btn btn-primary rounded-0 px-4">Inscribirse</a></p>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
        </div>
    </div>

      
    @include('contactenos')
    
    @include('footer')
     