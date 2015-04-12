@section('menu-in') header-in @stop

@section('blog-c') class="current-menu-item" @stop

@section('inicio') href="{{url('/#inicio')}}" @stop

@section('incuba') href="{{url('/#incuba')}}" @stop

@section('servicios') href="{{url('/#servicios')}}" @stop

@section('casos') href="{{url('/#emprendedores')}}" @stop

@section('blog') href="{{url('/#blog')}}" @stop

@section('contacto') href="{{url('/#contactanos')}}" @stop

@section('contenido')
    <section id="blog" class="section">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <hgroup class="section-title align-center">
                            <h1>Blog @if($slug<>"todos") - {{$slug}} @endif</h1>
                        </hgroup>
                    </div>
                </div>
                <div class="row">
                    <section id="main" class="col-md-8">
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <article class="entry main-entry">
                                    <div class="entry-image">
                                        <div class="work-item">
                                            {{HTML::image('Orb/images/entradas/'.$blog->imagen) }}
                                            <div class="image-extra">
                                                <div class="extra-content">
                                                    <div class="inner-extra">
                                                        <a class="single-image emo-icon" href="{{URL::asset('blogs/'.$blog->id)}}"></a>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <p>{{substr ($blog->entrada , 0, 500)}}</p>
                                    </div>
                                    <strong>{{HTML::link('blogs/'.$blog->slug.'/'.$blog->id,'Leer mas',array('class'=>'button default'))}}</strong>
                                    <span class="tags">
                                        @foreach($blog->tags as $tag_blog)
                                            <a href="{{ URL::asset('blogs/tag/'.substr(strip_tags(trim(str_replace(' ', '-', $tag_blog->nombre), '-')), 0, 100).'/'.$tag_blog->id) }}">{{$tag_blog->nombre}}</a>
                                        @endforeach
                                    </span>
                                </article>
                            @endforeach
                        @else
                            No hay ninguna entrada registrada
                        @endif
                        {{$blogs->links();}}
                    </section>
                    <aside id="sidebar" class="col-md-4">
                        <div class="widget widget_search">
                            {{ Form::open(array('url'=>'blogs/buscar', 'method' => 'post', 'id' => 'searchform') )}}
                                <p>
                                    {{Form::text('buscar', null, array('placeholder'=>'Buscar'))}}
                                    <button class="submit-search" type="submit">Buscar</button>
                                    <span class="message-error">{{$errors->first('buscar')}}</span>
                                </p>
                            {{Form::close()}}
                        </div>
                        <div class="widget widget_text">
                            <a href="{{URL::asset('incubacion')}}"><img alt="" src="{{ URL::asset('accio/images/body/taller en linea INADEM.png') }}" style="width:100%;"/></a>
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
                                        <a href="{{ URL::asset('blogs/tag/'.substr(strip_tags(trim(str_replace(' ', '-', $tag->nombre), '-')), 0, 100).'/'.$tag->id) }}">{{$tag->nombre}}</a>
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