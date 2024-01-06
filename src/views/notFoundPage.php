<?php
namespace App\Views;


$pageTitle = 'Error !';
$pageStyle = 'not-found-styles.css';

$pageContent = <<<HTML
    <main>
        <article>
            <div class="center-content">
                <section>
                    <h1>Error !</h1>
                    <p><a href="/">The page your are request not exit. Please, <strong>return to the homepage.</strong></a></p>
                </section>
            </div>
        </article>
    </main>
HTML;

require_once 'templates' . DIRECTORY_SEPARATOR . 'basicTemplate.php';
