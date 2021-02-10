<?php
ob_start();
?>
<nav id="navBar">
	<span class="btn">&#8594;</span>
    <p class="navigation">Navigation</p>
	<ul id="nav-tissue">
		<li class="li title">Tissus</li>
    </ul>
    <ul id="nav-clothes">
		<li class="li title">Vêtements<li>
        <ul id="nav-clothes-sexe">
            <li class="li">Homme</li>
            <li class="li">Femme</li>
        </ul>
        <ul id="nav-clothes-types"></ul>
	</ul>
	<ul id="nav-footer">
		<li class="li"><a href="#about">À Propos</a></li>
		<li class="li"><a href="#contact">Contact</a></li>
    </ul>
</nav>
<?php
echo ob_get_clean();
