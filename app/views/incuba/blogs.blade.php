@section('menu')
    <header id="header">
        <div class="header-in">
            <ul class="social-icons" style="display: inline-block; vertical-align: middle;">
                    <li class="twitter"><a href="https://twitter.com/IncubaMas"><i class="icon-twitter"></i>Twitter</a></li>
                    <li class="facebook"><a href="https://www.facebook.com/IncubaMas"><i class="icon-facebook"></i>Facebook</a></li>
                    <br/>
                    <li class="gplus"><a href="https://plus.google.com/+IncubaM%C3%A1sCelaya/posts"><i class="icon-gplus"></i>Gplus</a></li>
                    <li class="linkedin"><a href="https://www.linkedin.com/company/incubam%C3%A1s"><i class="icon-linkedin"></i>LinkedIn</a></li>
            </ul><!--/ .social-icons-->
            <h1 id="logo">
                <a href="/"><img alt="Incubamas" src="{{ URL::asset('accio/images/Logo footer.png') }}"  /></a>
            </h1>
            <a id="responsive-nav-button" class="responsive-nav-button" href="#"></a>
            <nav id="navigation" class="navigation">
                <ul>
                    <li>{{HTML::link('incuba#inicio','Inicio')}}</li>
                    <li>{{HTML::link('incuba#incuba','Incuba')}}</li>
                    <li>{{HTML::link('incuba#servicios','Servicios')}}</li>
                    <li>{{HTML::link('incuba#emprendedores','Emprendedores')}}</li>
                    <li class="current-menu-item">{{HTML::link('incuba#blog','Blog')}}</li>
                    <li>{{HTML::link('incuba#nosotros','Nosotros')}}</li>
                    <li>{{HTML::link('incuba#contactanos','Cont&aacute;ctanos')}}</li>
                </ul>
            </nav><!--/ #navigation-->			    
        </div><!--/ .header-in-->
    </header><!--/ #header-->
@stop

@section('contenido')
    <section id="blog" class="section">
	<div id="content">
	    <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <hgroup class="section-title align-center">
                            <h1>Blog</h1>
                        </hgroup>	
                    </div>
                </div><!--/ .row-->
                <div class="row">
		    <section id="main" class="col-md-8">
                        @if(count($blogs) > 0)
                            @foreach($blogs as $blog)
                                <article class="entry main-entry">
				    <div class="entry-image">
					<div class="work-item">
                                            <img src="{{ URL::asset('Orb/images/entradas/'.$blog->imagen) }}" alt="" />
                                            <div class="image-extra">
						<div class="extra-content">
						    <div class="inner-extra">
							<a class="single-image emo-icon" href="{{URL::asset('incuba/blog/'.$blog->id)}}"></a>
						    </div><!--/ .inner-extra-->	
						</div><!--/ .extra-content-->
					    </div><!--/ .image-extra-->	
					</div><!--/ .work-item-->	
				    </div><!--/ .entry-image-->
                                    <div class="entry-meta">
                                        <?php
                                            $date = date_create($blog->fecha_publicacion);
                                            $fecha=date_format($date, 'd-m-Y');
                                        ?>
                                        <span class="date"><a href="#">{{$fecha}}</a></span>
                                        <span>en <a href="#">{{$blog->nombre}}</a></span>
                                        <span>por <a href="#">IncubaM&aacute;s</a></span>							
                                        <span>{{$blog->comentarios}} Comentarios</span>
                                    </div><!--/ .entry-meta-->
                                    <h2 class="entry-title">
                                        <a href="{{URL::asset('incuba/blog/'.$blog->id)}}">{{$blog->titulo}}</a>
                                    </h2><!--/ .entry-title-->
                                    <div class="entry-body">
                                        <p>
                                            {{substr ($blog->entrada , 0, 500)}}
                                        </p>
                                    </div><!--/ .entry-body-->
                                    <strong>{{HTML::link('incuba/blog/'.$blog->id,'Leer mas',array('class'=>'button default'))}}</strong>
                                </article><!--/ .entry-->
                                
                            @endforeach
                        @else
                            No hay ninguna entrada registrada
                        @endif
                        {{$blogs->links();}}					
		    </section><!--/ #main-->
                    <aside id="sidebar" class="col-md-4"> 
                        <div class="widget widget_search">
                            {{ Form::open(array('url'=>'incuba/blogs/buscar', 'method' => 'post', 'id' => 'searchform') )}}
				<p>
				    {{Form::text('buscar', null, array('placeholder'=>'Buscar'))}}
				    <button class="submit-search" type="submit">Buscar</button>
				    <span class="message-error">{{$errors->first('buscar')}}</span>
				</p>
			    {{Form::close()}}	
                        </div><!--/ .widget-->
                        <div class="widget widget_text">
			    <a href="{{URL::asset('incuba/incubacion')}}"><img alt="" src="{{ URL::asset('accio/images/body/taller en linea INADEM.png') }}" style="width:100%;"/></a>
			</div><!--/ .widget-->
                        <div class="widget widget_categories">
                            <h3 class="widget-title">Categorias</h3>
                            @if(count($categorias) > 0)
                                <ul>
                                @foreach($categorias as $categoria)
                                    <li><a href="{{ URL::asset('incuba/blogs/categoria/'.$categoria->id) }}">{{$categoria->nombre}}</a></li>
                                @endforeach
                                </ul>
                            @else
                                No hay ninguna categoria registrada
                            @endif
                        </div><!--/ .widget-->
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget-title">Tags</h3>
                            @if(count($tags) > 0)
                                <div class="tagcloud">
                                @foreach($tags as $tag)
                                    <a href="{{ URL::asset('incuba/blogs/tag/'.$tag->id) }}">{{$tag->nombre}}</a>
                                @endforeach
                                </div>
                            @else
                                No hay ningun tag registrado
                            @endif
                        </div><!--/ .widget-->
                        <div class="widget widget_recent_posts">
			    @if(count($recent_blogs) > 0)
                                <h3 class="widget-title">Entradas Recientes</h3>
				<section>
                                @foreach($recent_blogs as $recent_blog)
                                    <article class="entry"> 
				    <div class="entry-image">
					<a href="{{URL::asset('incuba/blog/'.$recent_blog->id)}}" class="single-image">
					    <img alt="" src="{{ URL::asset('Orb/images/entradas/'.$recent_blog->imagen) }}" style="width:90px;"/>
					</a>	
				    </div><!--/ .entry-image-->
				    <div class="post-holder">
					<div class="entry-meta">
					    <?php
						$date = date_create($recent_blog->fecha_publicacion);
						$fecha=date_format($date, 'd-m-Y');
					    ?>
					    <span class="date"><a href="#">{{$fecha}}</a></span>
					    <span>{{$recent_blog->comentarios}} Comentarios</span>
					</div><!--/ .entry-meta-->
					<h6 class="entry-title">
					    <a href="{{URL::asset('incuba/blog/'.$recent_blog->id)}}">{{$recent_blog->titulo}}</a>
					</h6>
				    </div><!--/ .post-holder-->
				</article><!--/ .entry-->
                                @endforeach
                                </section>
                            @endif
			</div><!--/ .widget-->
                        <div class="widget widget_archive">
                            @if(count($archive_blogs) > 0)
                                <h3 class="widget-title">Archivos</h3>
				<ul>
                                @foreach($archive_blogs as $archive_blog)
                                    <li><a href="{{URL::asset('incuba/blogs/archivos/'.$archive_blog->month.'-'.$archive_blog->year)}}">
					<?php
					    switch($archive_blog->month){
						case 1: echo "Enero"; break;
						case 2: echo "Febrero"; break;
						case 3: echo "Marzo"; break;
						case 4: echo "Abril"; break;
						case 5: echo "Mayo"; break;
						case 6: echo "Junio"; break;
						case 7: echo "Julio"; break;
						case 8: echo "Agosto"; break;
						case 9: echo "Septiembre"; break;
						case 10: echo "Octubre"; break;
						case 11: echo "Noviembre"; break;
						case 12: echo "Diciembre"; break;
					    }
					?>
					{{$archive_blog->year}}
				    </a></li>
                                @endforeach
                                </ul>
                            @endif
                        </div><!--/ .widget-->
                    </aside><!--/ #sidebar-->
		</div><!--/ .row-->
	    </div><!--/ .container-->
	</div><!--/ #content-->
    </section><!--/ .section-->
@stop