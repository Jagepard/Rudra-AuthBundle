<?php

/* login.html.twig */
class __TwigTemplate_1c13530f1d9c3728a8c043ace7f68764bdc7e756eeb4573fb4848a1c38f9cb93 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html.twig", "login.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "
    <h1 class=\"form-heading\">";
        // line 5
        echo twig_escape_filter($this->env, ($context["brand"] ?? null), "html", null, true);
        echo "</h1>
    <div class=\"login-form\">
        <div class=\"main-div\">
            <div class=\"panel\">
                <h2>Введите Ваш email и пароль</h2>
            </div>
            <hr>
            <form role=\"form\" method=\"POST\" action=\"stargate\">
                ";
        // line 13
        echo call_user_func_array($this->env->getFunction('csrf_field')->getCallable(), array());
        echo "
                <div class=\"form-group\">
                    <input type=\"email\" class=\"form-control\" id=\"name\" placeholder=\"Имя пользователя\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('value')->getCallable(), array("name")), "html", null, true);
        echo "\" name=\"name\">
                    ";
        // line 16
        echo call_user_func_array($this->env->getFunction('alert')->getCallable(), array("name", "warning"));
        echo "
                </div>

                <div class=\"form-group\">
                    <input type=\"password\" class=\"form-control\" id=\"pass\" placeholder=\"Пароль\" name=\"pass\">
                    ";
        // line 21
        echo call_user_func_array($this->env->getFunction('alert')->getCallable(), array("pass", "warning"));
        echo "
                </div>

                <div class=\"form-group\">
                    <label>
                        <input type=\"checkbox\" name=\"remember_me\"> Запомнить меня
                    </label>
                </div>

                <div class=\"forgot\">
                    <a href=\"reset.html\">Забыли пароль?</a>
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">Войти</button>
            </form>
        </div>

        <p class=\"botto-text\"> Коротков Данила</p>
    </div>
";
    }

    public function getTemplateName()
    {
        return "login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 21,  54 => 16,  50 => 15,  45 => 13,  34 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html.twig\" %}

{% block content %}

    <h1 class=\"form-heading\">{{ brand }}</h1>
    <div class=\"login-form\">
        <div class=\"main-div\">
            <div class=\"panel\">
                <h2>Введите Ваш email и пароль</h2>
            </div>
            <hr>
            <form role=\"form\" method=\"POST\" action=\"stargate\">
                {{ csrf_field() | raw}}
                <div class=\"form-group\">
                    <input type=\"email\" class=\"form-control\" id=\"name\" placeholder=\"Имя пользователя\" value=\"{{ value('name') }}\" name=\"name\">
                    {{ alert('name', 'warning') | raw }}
                </div>

                <div class=\"form-group\">
                    <input type=\"password\" class=\"form-control\" id=\"pass\" placeholder=\"Пароль\" name=\"pass\">
                    {{ alert('pass', 'warning') | raw }}
                </div>

                <div class=\"form-group\">
                    <label>
                        <input type=\"checkbox\" name=\"remember_me\"> Запомнить меня
                    </label>
                </div>

                <div class=\"forgot\">
                    <a href=\"reset.html\">Забыли пароль?</a>
                </div>
                <button type=\"submit\" class=\"btn btn-primary\">Войти</button>
            </form>
        </div>

        <p class=\"botto-text\"> Коротков Данила</p>
    </div>
{% endblock %}
", "login.html.twig", "/home/d/projects/jagepard/rudra/SiteCore/app/auth/Resources/twig/view/login.html.twig");
    }
}
