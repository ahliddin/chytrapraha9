<?php
// source: C:\xampp\htdocs\chytrapraha9\app/templates/@layout.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8501977742', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block styles
//
if (!function_exists($_b->blocks['styles'][] = '_lb3e97fd86d3_styles')) { function _lb3e97fd86d3_styles($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lb39a6cfd4bf_head')) { function _lb39a6cfd4bf_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb4eaa4de431_scripts')) { function _lb4eaa4de431_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo Latte\Runtime\Filters::escapeHtml($metaDescription, ENT_COMPAT) ?>">
        <meta name="keywords" content="<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($metaKeywords) as $kw) { echo Latte\Runtime\Filters::escapeHtml($kw, ENT_COMPAT) ;if (!$iterator->isLast()) { ?>
,<?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>">
        <link rel="icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/img/favicon.ico">

        <title><?php if (isset($_b->blocks["title"])) { ob_start(); Latte\Macros\BlockMacros::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>Chytrá Praha 9</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/global.style.css" rel="stylesheet">
        <?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['styles']), $_b, get_defined_vars())  ?>

        <?php call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>

    </head>
    <body>
	<script> document.documentElement.className+=' js' </script>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#"><img src="/img/logo.png" alt="" id="logo-img"></a>
                    <a class="navbar-brand" href="#">Chytrá Praha 9</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Základní školy</a></li>
                        <li><a href="#contact">Střední školy a gymnázia</a></li>
                        <li><a href="#contact">Mateřské školy</a></li>
                        <li><a href="#contact">Vzdělavácí centra</a></li>
                        <li><a href="#contact">Kulturní střediska</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            
<?php Latte\Macros\BlockMacros::callBlock($_b, 'content', $template->getParameters()) ?>

            

        </div><!-- /.container -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/jquery.min.js"></script>
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/netteForms.js"></script>
        <script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/global.script.js"></script>
        <?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

    </body>
</html>
