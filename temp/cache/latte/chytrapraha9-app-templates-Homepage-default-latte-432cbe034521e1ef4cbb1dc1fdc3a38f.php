<?php
// source: C:\xampp\htdocs\chytrapraha9\app/templates/Homepage/default.latte

// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9738773824', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb180007c786_content')) { function _lb180007c786_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div id="content">
    <div class="starter-template">
<?php call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>
        <p class="lead"></p>
    </div>
</div>
<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb6347068667_title')) { function _lb6347068667_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>        <h1>Param-pam-pam</h1>
<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lbcd5888122f_scripts')) { function _lbcd5888122f_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacros::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/js/index.script.js"></script>
<?php
}}

//
// block styles
//
if (!function_exists($_b->blocks['styles'][] = '_lb3e5a668a9f_styles')) { function _lb3e5a668a9f_styles($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacros::callBlockParent($_b, 'styles', get_defined_vars()) ?>
<script src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/index.style.js"></script>
<?php
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

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['styles']), $_b, get_defined_vars()) ; 