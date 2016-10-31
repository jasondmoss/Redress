<?php

/**
 * ...
 *
 * @category   Development
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


namespace MU\Classes;

/**
 * Class Development
 *
 * @package mu-plugins\Classes
 */
class Development
{

    /**
     * Development constructor.
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        global $devel;
        if (false === $devel) {
            return false;
        }

        /**
         * Record any of WordPress' plugin activation errors to an HTML file, as
         * the debugging/error reporting functionality of WordPress, even on its
         * best day, leaves much to desire.
         */
        add_action('activated_plugin', function () {
            ob_start();
            file_put_contents(
                ABSPATH .'wp-content/uploads/pluginActivationErrors.html',
                ob_get_contents()
            );
        }, 3, 0);

        foreach ([ 'admin_head', 'wp_head' ] as $action) {
            add_action($action, [$this, 'printDevServerCommentMessage']);
        }

        foreach ([ 'admin_footer', 'login_footer', 'wp_footer' ] as $action) {
            add_action($action, [$this, 'displayDevelopmentBar']);
        }
    }


    /* -- */


    /**
     * Print out development message as HTML comment.
     *
     * @return void
     * @access public
     * @final
     */
    final public function printDevServerCommentMessage()
    {
        echo <<<MSG



<!--

********************************************************************************
  *                                                                          *
  *                                                                          *
  *            YOU ARE CURRENTLY WORKING ON THE DEVELOPMENT SERVER           *
  *                      WITH _FULL_ DEBUGGING ENABLED!                      *
  *                                                                          *
  *                                                                          *
********************************************************************************

-->




MSG;
    }


    /**
     * Development notification bar.
     *
     * @return void
     * @access public
     * @final
     */
    final public function displayDevelopmentBar()
    {
        switch ($_SERVER['HTTP_HOST']) {
            case 'remote.development.server':
                $server = '&#160;&#160;(remote)';
                break;

            case 'localhost':
            default:
                $server = '&#160;&#160;(localhost)';
                break;
        }

        echo "\n<div class=\"development-bar\"><p>Under Development {$server}</p></div>\n";
    }


    /* -- */


    /**
     * Print supplied MySQL statement as a string to the screen.
     *
     * @param string $sql SQL query string.
     *
     * @return void
     * @access public
     * @final
     */
    final public function printSql($sql)
    {
        echo "\n\n\n<pre><code>". $sql->__toString() ."</code></pre>\n\n\n";
    }


    /**
     * Print out current rewrite rules registered with WordPress.
     *
     * @global \WP_Rewrite $wp_rewrite
     *
     * @return void
     * @access public
     * @final
     */
    final public function printRewriteRules()
    {
        global $wp_rewrite;

        echo "<div style=\"padding:1em;border:1px solid #0ff;background:#c3ffff;font:normal normal bold 12px/1.2".
            " Edlo,Inconsolata,'Courier New','Times New Roman',serif;color:#000\">";
        if (!empty($wp_rewrite->extra_rules_top)) {
            echo '<h5>Rewrite Rules</h5><table><thead><tr><td>Rule</td><td>Rewrite</td></tr></thead><tbody>';
            foreach ($wp_rewrite->extra_rules_top as $name => $value) {
                echo "<tr><td>{$name}</td><td>{$value}</td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo 'No rules defined.';
        }
        echo '</div>';
    }


    /**
     * "Pretty Print" variable properties for debugging/testing purposes.
     *
     * @param mixed   $var   Variable to print.
     * @param string  $label Label/title for the output.
     * @param boolean $exit  Exit after dumping the variable? Dafault false.
     *
     * @return void
     * @access public
     *
     * @example Dump the $post variable, with a custom label, then exit.
     *          dump($post, 'Post Properties Array', true);
     * @final
     */
    final public function dump($var, $label = '', $exit = false)
    {
        echo "\n\n\n\n<div class=\"message dump\"><pre>";

        if (!empty($label)) {
            echo "<h4>{$label}</h4>";
        }

        echo "\n\n";
        if (empty($var)) {
            echo 'EMPTY';
        } elseif (false === $var) {
            echo 'FALSE';
        } elseif (is_null($var)) {
            echo 'NULL';
        } elseif (is_array($var) || is_object($var)) {
            print_r($var);
        } else {
            echo $var;
        }

        echo "\n\n</pre></div>\n\n\n\n";

        if ($exit) {
            exit;
        }
    }
}

/* <> */
