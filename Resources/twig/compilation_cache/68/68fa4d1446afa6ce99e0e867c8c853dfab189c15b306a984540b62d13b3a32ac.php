<?php

/* layout.html.twig */
class __TwigTemplate_0c5359e311f2c6fff0ed6d02e89735f1b2563d54cc7694f01ba181a3fa02c9b1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"ru_RU\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=0.8\">

    <title>Админка :: ";
        // line 8
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title>

    <link rel=\"shortcut icon\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, twig_constant("APP_URL"), "html", null, true);
        echo "/assets/auth/framework.ico\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, twig_constant("APP_URL"), "html", null, true);
        echo "/assets/auth/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, twig_constant("APP_URL"), "html", null, true);
        echo "/assets/auth/css/custom.css\">
</head>
<body style=\"zoom: 80%; background-image : url(";
        // line 14
        echo twig_escape_filter($this->env, twig_constant("APP_URL"), "html", null, true);
        echo "/assets/auth/images/parallax-bg.jpg);\">
<div class=\"container\">

    ";
        // line 17
        $this->displayBlock('content', $context, $blocks);
        // line 18
        echo "
</div>
</body>
</html>
";
    }

    // line 17
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 17,  55 => 18,  53 => 17,  47 => 14,  42 => 12,  38 => 11,  34 => 10,  29 => 8,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.html.twig", "/home/d/projects/jagepard/rudra/SiteCore/app/auth/Resources/twig/view/layout.html.twig");
    }
}
