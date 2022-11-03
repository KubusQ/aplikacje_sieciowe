<?php

/* calc.html */
class __TwigTemplate_2ffd98226766e53b9580ee896ce8a38764c538f6e7812cf0b75f8d6712d2810f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("main.html", "calc.html", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "main.html";
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
<h2 class=\"content-head is-center\">Prosty kalkulator</h2>

<div class=\"pure-g\">
<div class=\"l-box-lrg pure-u-1 pure-u-med-2-5\">
\t<form class=\"pure-form pure-form-stacked\" action=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["app_url"]) ? $context["app_url"] : null), "html", null, true);
        echo "/app/calc.php\" method=\"post\">
\t\t<fieldset>
\t\t<label for=\"id_x\">Podaj kwotę: </label>
\t<input id=\"id_x\" type=\"text\" name=\"x\" placeholder=\"Kwota kredytu\" /><br />
\t<label for=\"id_y\">Podaj oprocentowanie: </label>
\t<input id=\"id_y\" type=\"text\" name=\"y\" placeholder=\"Oprocentowanie\" /><br />
\t<label for=\"id_z\">Podaj liczbę lat: </label>
\t<input id=\"id_z\" type=\"text\" name=\"z\" placeholder=\"Liczba lat\" /><br />
\t<input type=\"submit\" value=\"Oblicz\" />
\t</form>
</fieldset>
</div>

<div class=\"l-box-lrg pure-u-1 pure-u-med-3-5\">";
        // line 25
        if (array_key_exists("messages", $context)) {
            // line 26
            if ((twig_length_filter($this->env, (isset($context["messages"]) ? $context["messages"] : null)) > 0)) {
                // line 27
                ob_start();
                // line 28
                echo "\t\t<h4>Wystąpiły błędy: </h4>
\t\t<ol class=\"err\">";
                // line 30
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable((isset($context["messages"]) ? $context["messages"] : null));
                foreach ($context['_seq'] as $context["_key"] => $context["msg"]) {
                    // line 31
                    echo "\t\t\t<li>";
                    echo twig_escape_filter($this->env, $context["msg"], "html", null, true);
                    echo "</li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['msg'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 33
                echo "\t\t</ol>";
                echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
            }
        }
        // line 39
        if (array_key_exists("result", $context)) {
            // line 40
            echo "\t<h4>Wynik</h4>
\t<p class=\"res\">
\t\tSuma kredytu:";
            // line 42
            echo twig_escape_filter($this->env, (isset($context["sum"]) ? $context["sum"] : null), "html", null, true);
            echo "
\t</p>
\t<p class=\"res\">
\t\tMiesięczna rata:";
            // line 45
            echo twig_escape_filter($this->env, (isset($context["result"]) ? $context["result"] : null), "html", null, true);
            echo "
\t</p>";
        }
        // line 48
        echo "
</div>
</div>";
    }

    public function getTemplateName()
    {
        return "calc.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 48,  92 => 45,  86 => 42,  82 => 40,  80 => 39,  75 => 33,  67 => 31,  63 => 30,  60 => 28,  58 => 27,  56 => 26,  54 => 25,  38 => 9,  31 => 4,  28 => 3,  11 => 1,);
    }
}
/* {% extends "main.html" %}*/
/* */
/* {% block content %}*/
/* */
/* <h2 class="content-head is-center">Prosty kalkulator</h2>*/
/* */
/* <div class="pure-g">*/
/* <div class="l-box-lrg pure-u-1 pure-u-med-2-5">*/
/* 	<form class="pure-form pure-form-stacked" action="{{app_url}}/app/calc.php" method="post">*/
/* 		<fieldset>*/
/* 		<label for="id_x">Podaj kwotę: </label>*/
/* 	<input id="id_x" type="text" name="x" placeholder="Kwota kredytu" /><br />*/
/* 	<label for="id_y">Podaj oprocentowanie: </label>*/
/* 	<input id="id_y" type="text" name="y" placeholder="Oprocentowanie" /><br />*/
/* 	<label for="id_z">Podaj liczbę lat: </label>*/
/* 	<input id="id_z" type="text" name="z" placeholder="Liczba lat" /><br />*/
/* 	<input type="submit" value="Oblicz" />*/
/* 	</form>*/
/* </fieldset>*/
/* </div>*/
/* */
/* <div class="l-box-lrg pure-u-1 pure-u-med-3-5">*/
/* */
/* {# wyświeltenie listy błędów, jeśli istnieją #}*/
/* {% if messages is defined %}*/
/* 	{% if messages|length > 0 %} */
/* 		{% spaceless %}*/
/* 		<h4>Wystąpiły błędy: </h4>*/
/* 		<ol class="err">*/
/* 		{% for msg in messages %}*/
/* 			<li>{{ msg }}</li>*/
/* 		{% endfor %}*/
/* 		</ol>*/
/* 		{% endspaceless %}*/
/* 	{% endif %}*/
/* {% endif %}*/
/* */
/* */
/* {% if result is defined %}*/
/* 	<h4>Wynik</h4>*/
/* 	<p class="res">*/
/* 		Suma kredytu: {{sum}}*/
/* 	</p>*/
/* 	<p class="res">*/
/* 		Miesięczna rata: {{result}}*/
/* 	</p>*/
/* {% endif %}*/
/* */
/* </div>*/
/* </div>*/
/* */
/* {% endblock %}*/
