@section('menu-in') header-in @stop

@section('blog-c') class="current-menu-item" @stop

@section('inicio') href="{{url('/#inicio')}}" @stop

@section('incuba') href="{{url('/#incuba')}}" @stop

@section('servicios') href="{{url('/#servicios')}}" @stop

@section('casos') href="{{url('/#emprendedores')}}" @stop

@section('blog') href="{{url('/#noticias')}}" @stop

@section('contacto') href="{{url('/#contactanos')}}" @stop

@section('contenido')
    <section class="section">
	    <div id="content">
	        <div class="container">
		        <div class="row">
		            <section id="main" class="col-md-8">
                        <article class="entry main-entry">
                            <div class="entry-image">
                                <div class="work-item">
                                    {{HTML::image('Orb/images/entradas/'.$blog->imagen) }}
                                </div>
                            </div>
                            <div class="entry-meta">
                                <span class="date"><a style="color: #5b5e60;">{{$blog->publicacion}}</a></span>
                                <span>en <a href="{{ URL::asset('blogs/categoria/'.substr(strip_tags(trim(str_replace(' ', '-', $blog->categoria->nombre), '-')), 0, 100).'/'.$blog->categoria->id) }}">{{$blog->categoria->nombre}}</a></span>
                                <span>por <a href="#">IncubaM&aacute;s</a></span>
                                <span>{{$blog->comentarios}} Comentarios</span>
                            </div>
                            <h2 class="entry-title">
                                <a href="{{URL::asset('blogs/'.$blog->slug.'/'.$blog->id)}}">{{$blog->titulo}}</a>
                            </h2>
                            <div class="entry-body">
                                <p>{{$blog->entrada}}</p>
                            </div>
                            <span class="tags">
                                @foreach($blog->tags as $tag_blog)
                                    <a href="{{ URL::asset('blogs/tag/'.substr(strip_tags(trim(str_replace(' ', '-', $tag_blog->tag), '-')), 0, 100).'/'.$tag_blog->id) }}">{{$tag_blog->tag}}</a>
                                @endforeach
                            </span>
                        </article>
                        <div class="col-xs-12">
                            <div class="align-center opacity">
                                {{HTML::link('blogs','Ver todas las entradas',array('class'=>'button large default'))}}
                            </div>
                        </div>
                        <section id="comments">
                            <h3>Comentarios</h3>
                            @if(count($blog->comentario) > 0)
                                <ol class="comments-list">
                                    @foreach($blog->comentario as $comentario)
                                        <li class="comment">
                                            <article>
                                                <div class="gravatar">{{HTML::image('accio/images/avatars/'.$comentario->foto, null, ['style'=>"width:60px;"]) }}</div>
                                                <div class="comment-body">
                                                    <div class="comment-meta">
                                                        <div class="comment-author"><h6><a style="color: #5b5e60;">{{$comentario->nombre}}</a></h6></div>
                                                        <div class="comment-date"><a style="color: #5b5e60;">{{date_format(date_create($comentario->created_at), 'd-m-Y \a \l\a\s H:m:s')}}</a></div>
                                                    </div>
                                                    <p>{{$comentario->comentario}}</p>
                                                </div>
                                            </article>
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                No hay ninguna comentario
                            @endif
                        </section>
                        <section id="respond">
                            <h3>Deja tu comentario</h3>
                            @if(Session::get('confirm')||count($errors)>0)
                                <script>
                                    location.href = "#comments"
                                </script>
                            @endif
                            @if(Session::get('confirm'))
                                <p class="success">¡Gracias por tu comentario!<a class="alert-close" href="#"></a></p><br/>
                            @endif
                            @if(count($errors)>0)
                                <p class="error">¡Por favor, revise los datos del formulario!<a class="alert-close" href="#"></a></p><br/>
                            @endif
                            <span class="message-error">{{$errors->first('entrada')}}</span>
                            {{Form::open(['url'=>'blogs/comentario', 'method' => 'post', 'class'=>'comments-form'])}}
                                {{Form::hidden('entrada_id',$blog->id)}}
                                <p class="input-block">
                                    {{Form::text('nombre', null, ['placeholder'=>'Nombre'])}}<br/>
                                    <span class="message-error">{{$errors->first('nombre')}}</span>
                                </p>
                                <p class="input-block">
                                    {{ Form::textarea('comentario', null, ['placeholder'=>'comentario']) }}<br/>
                                    <span class="message-error">{{$errors->first('comentario')}}</span>
                                </p>
                                <p class="input-block">
                                    <span class="col-md-2 align-center">
                                        {{HTML::image('accio/images/avatars/avatar1_big.png', null, ['style'=>"width:60px;"])}}<br/>
                                        {{Form::radio('foto', 'avatar1_big.png', true)}}
                                    </span>
                                    <span class="col-md-2 align-center">
                                        {{HTML::image('accio/images/avatars/avatar2_big.png', null, ['style'=>"width:60px;"])}}<br/>
                                        {{Form::radio('foto', 'avatar2_big.png')}}
                                    </span>
                                    <span class="col-md-2 align-center">
                                        {{HTML::image('accio/images/avatars/avatar3_big.png', null, ['style'=>"width:60px;"])}}<br/>
                                        {{Form::radio('foto', 'avatar3_big.png')}}
                                    </span>
                                    <span class="col-md-2 align-center">
                                        {{HTML::image('accio/images/avatars/avatar4_big.png', null, ['style'=>"width:60px;"])}}<br/>
                                        {{Form::radio('foto', 'avatar4_big.png')}}
                                    </span>
                                    <span class="col-md-2 align-center">
                                        {{HTML::image('accio/images/avatars/avatar5_big.png', null, ['style'=>"width:60px;"])}}<br/>
                                        {{Form::radio('foto', 'avatar5_big.png')}}
                                    </span>
                                </p>
                                <br/><br/><br/><br/>
                                <p class="input-block">
                                    {{Form::captcha()}}
                                    <span class="message-error">{{$errors->first('recaptcha_response_field')}}</span><br/>
                                </p>
                                <p class="input-block">
                                    <button class="button default middle" type="submit" id="submit">Enviar comentario</button>
                                </p>
                                <div class="g-recaptcha" data-sitekey="6Ldd3gsTAAAAAPW7OksSy7M8KUF1NSyrCx77pwhX"></div>
                            {{Form::close()}}
                        </section>
		            </section>
                    <aside id="sidebar" class="col-md-4">
                        <div class="widget widget_search">
                            {{ Form::open(['url'=>'blogs/buscar', 'method' => 'post', 'id' => 'searchform'])}}
                            <p>
                                {{Form::text('buscar', null, ['placeholder'=>'Buscar'])}}
                                <button class="submit-search" type="submit">Buscar</button>
                                <span class="message-error">{{$errors->first('buscar')}}</span>
                            </p>
                            {{Form::close()}}
                        </div>
                        <div class="widget widget_categories">
                            <h3 class="widget-title">Categorias</h3>
                            @if(count($categorias) > 0)
                                <ul>
                                    @foreach($categorias as $categoria)
                                        <li><a href="{{ URL::asset('blogs/categoria/'.substr(strip_tags(trim(str_replace(' ', '-', $categoria->nombre), '-')), 0, 100).'/'.$categoria->id) }}">{{$categoria->nombre}}</a></li>
                                    @endforeach
                                </ul>
                            @else
                                No hay ninguna categoria registrada
                            @endif
                        </div>
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget-title">Tags</h3>
                            @if(count($tags) > 0)
                                <div class="tagcloud">
                                    @foreach($tags as $tag)
                                        <a href="{{ URL::asset('blogs/tag/'.substr(strip_tags(trim(str_replace(' ', '-', $tag->tag), '-')), 0, 100).'/'.$tag->id) }}">{{$tag->tag}}</a>
                                    @endforeach
                                </div>
                            @else
                                No hay ningun tag registrado
                            @endif
                        </div>
                        <div class="widget widget_recent_posts">
                            @if(count($recent_blogs) > 0)
                                <h3 class="widget-title">Entradas Recientes</h3>
                                <section>
                                    @foreach($recent_blogs as $recent_blog)
                                        <article class="entry">
                                            <div class="entry-image">
                                                <a href="{{URL::asset('blogs/'.$recent_blog->slug.'/'.$recent_blog->id)}}" class="single-image">
                                                    <img alt="" src="{{ URL::asset('Orb/images/entradas/'.$recent_blog->imagen) }}" style="width:90px;"/>
                                                </a>
                                            </div>
                                            <div class="post-holder">
                                                <div class="entry-meta">
                                                    <span class="date"><a style="color: #5b5e60;">{{$blog->publicacion}}</a></span>
                                                    <span>{{$recent_blog->comentarios}} Comentarios</span>
                                                </div>
                                                <h6 class="entry-title">
                                                    <a href="{{URL::asset('blogs/'.$recent_blog->slug.'/'.$recent_blog->id)}}">{{$recent_blog->titulo}}</a>
                                                </h6>
                                            </div>
                                        </article>
                                    @endforeach
                                </section>
                            @endif
                        </div>
                        <div class="widget widget_archive">
                            @if(count($archive_blogs) > 0)
                                <h3 class="widget-title">Archivos</h3>
                                <ul>
                                    @for($i=0; $i<count($archive_blogs); $i++)
                                        <li>
                                            <a href="{{URL::asset('blogs/archivos/'.$archive_blogs[$i]['month'].'/'.$archive_blogs[$i]['year'])}}">
                                                {{$archive_blogs[$i]['month']}} {{$archive_blogs[$i]['year']}}
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            @endif
                        </div>
                    </aside>
		        </div>
	        </div>
	    </div>
    </section>
@stop