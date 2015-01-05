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
    <section class="section">
	<div id="content">
	    <div class="container">
		<div class="row">
		    <section id="main" class="col-md-8">
			<article class="entry main-entry single">
                            <div class="entry-image">
                                <img src="{{ URL::asset('Orb/images/entradas/'.$blog->imagen) }}" alt="" />
                            </div><!--/ .entry-image-->
			    <div class="entry-meta">
                                <?php
                                    $date = date_create($blog->fecha_publicacion);
                                    $fecha=date_format($date, 'd-m-Y');
                                ?>
                                <span class="date"><a href="#">{{$fecha}}</a></span>
                                <span>en <a href="#">{{$blog->nombre}}</a></span>
                                <span>pro <a href="#">IncubaM&aacute;s</a></span>							
                                <span>{{$blog->comentarios}} Comentarios</span>
                            </div><!--/ .entry-meta-->
			    <h2 class="entry-title">{{$blog->titulo}}</h2><!--/ .entry-title-->
                            <div class="entry-body">
                                    <p>{{$blog->entrada}}</p>
                            </div><!--/ .entry-body-->
                            @if(count($tags_blog) > 0)
                                <span class="tags">
                                @foreach($tags_blog as $tag_blog)
                                    <a href="{{ URL::asset('incuba/blogs/tag/'.$tag_blog->id) }}">{{$tag_blog->nombre}}</a>
                                @endforeach
                                </span> <!--.tags-->
                            @endif
                        </article><!--/ .entry-->
			<div class="col-xs-12">
			    <div class="align-center opacity">
				{{HTML::link('incuba/blogs/todos','Ver todas las entradas',array('class'=>'button large default'))}}
			    </div>
			</div>
                        <!--<div class="single-post-nav clearfix">
                                <a title="Entrada anterior" class="prev" href="#">Entrada anterior</a>
                                <a title="Entrada siguiente" class="next" href="#">Entrada siguiente</a>
                        </div>/ .single-post-nav-->	
			<section id="comments">
			    <h3>Comentarios</h3>
			    @if(count($comment_blogs) > 0)
				<ol class="comments-list">
                                @foreach($comment_blogs as $comment_blog)
				    <li class="comment">
					<article>
					    <div class="gravatar"><img alt="" src="{{ URL::asset('accio/images/avatars/'.$comment_blog->foto) }}" style="width:60px;"></div>
					    <div class="comment-body">
						<div class="comment-meta">
						    <div class="comment-author"><h6><a href="#">{{$comment_blog->nombre}}</a></h6></div>
						    <?php
							$date = date_create($comment_blog->created_at);
							$fecha=date_format($date, 'd-m-Y \a \l\a\s H:m:s');
						    ?>
						    <div class="comment-date"><a href="#">{{$fecha}}</a></div>
						</div><!--/ .comment-meta-->
						<p>{{$comment_blog->comentario}}</p>
					    </div><!--/ .comment-body-->
					</article>
				    </li><!--/ .comment-->
				@endforeach
                                </ol><!--/ .comments-list-->
                            @else
                                No hay ninguna comentario
                            @endif
			</section><!--/ #comments-->
			<section id="respond">
			    <h3>Deja tu comentario</h3>
			    @if(Session::get('confirm'))
				{{Session::get('confirm')}}
			    @endif
			    <span class="message-error">{{$errors->first('entrada')}}</span>
			    {{ Form::open(array('url'=>'incuba/comentario', 'method' => 'post', 'class'=>'comments-form') )}}
				{{Form::hidden('entrada_id',$blog->entradaID)}}
				<p class="input-block">
				    {{Form::text('name', null, array('placeholder'=>'Nombre'))}}
				</p>
				<span class="message-error">{{$errors->first('name')}}</span>
				<p class="input-block">
				    {{ Form::textarea('message', null, array('placeholder'=>'Mensaje')) }}
				</p><br/>
				<p class="input-block">
				    <span class="col-md-2 align-center">
					<img alt="" src="{{ URL::asset('accio/images/avatars/avatar1_big.png') }}" style="width:60px;">
					<br/>{{Form::radio('avatar', 'avatar1_big.png', true)}}
				    </span>
				    <span class="col-md-2 align-center">
					<img alt="" src="{{ URL::asset('accio/images/avatars/avatar2_big.png') }}" style="width:60px;">
					<br/>{{Form::radio('avatar', 'avatar2_big.png')}}
				    </span>
				    <span class="col-md-2 align-center">
					<img alt="" src="{{ URL::asset('accio/images/avatars/avatar3_big.png') }}" style="width:60px;">
					<br/>{{Form::radio('avatar', 'avatar3_big.png')}}
				    </span>
				    <span class="col-md-2 align-center">
					<img alt="" src="{{ URL::asset('accio/images/avatars/avatar4_big.png') }}" style="width:60px;">
					<br/>{{Form::radio('avatar', 'avatar4_big.png')}}
				    </span>
				    <span class="col-md-2 align-center">
					<img alt="" src="{{ URL::asset('accio/images/avatars/avatar5_big.png') }}" style="width:60px;">
					<br/>{{Form::radio('avatar', 'avatar5_big.png')}}
				    </span>
				</p><br/><br/><br/><br/>
				<span class="message-error">{{$errors->first('message')}}</span>
				<p class="input-block">
				    {{Form::captcha()}}
				</p>
				<span class="message-error">{{$errors->first('recaptcha_response_field')}}</span>
				<p class="input-block">
				    <button class="button default middle" type="submit" id="submit">Enviar comentario</button>
				</p>
			    {{Form::close()}}<!--/ .comments-form-->	
			</section><!--/ #respond-->
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
			    <a href="{{URL::asset('incuba/incubacion')}}"><img alt="" src="{{ URL::asset('accio/images/body/taller en linea INADEM.png') }}" style="width:100%;"/></a
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