<?php

/**
 * WordPress Log-In Enhancements.
 *
 * @category   Access
 * @package    WordPress
 * @subpackage MustUsePlugin|Redress
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  2016 Jason D. Moss. All rights freely given.
 * @license    https://raw.githubusercontent.com/jasondmoss/mu-plugins/master/LICENSE.md [WTFPL License]
 * @link       https://github.com/jasondmoss/mu-plugins/
 */


namespace MU\Classes;

/**
 * Class Access
 *
 * @package mu-plugins\Classes
 */
class Access
{

    /**
     *
     */
    protected $bloginfo;


    /**
     * Access constructor.
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        foreach ([ 'name', 'description', 'url' ] as $param) {
            $this->bloginfo[$param] = get_bloginfo($param);
        }

        /* Customize the Login page. */
        add_filter('login_headerurl', [$this, 'replaceLoginHeaderUrl']);
        add_filter('login_headertitle', [$this, 'replaceLoginHeaderTitle']);
        // add_filter('login_errors', [$this, 'loginFailed']);

        /* Swap out the default WordPress "authenticate" filter with our own. */
        remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
        add_filter('authenticate', [$this, 'loginEmailAuthentication'], 20, 3);

        add_filter('login_message', [$this, 'addNewHeaderTitle']);
        add_action('login_form', [$this, 'loginWithUsernameOrEmail']);
    }


    /* -- */


    /**
     * Replace the WordPress link with this website's home URL.
     *
     * @return string
     * @access public
     */
    public function replaceLoginHeaderUrl()
    {
        return $this->bloginfo['url'];
    }


    /**
     * Replace the WordPress title with this website's name.
     *
     * @return string
     * @access public
     */
    public function replaceLoginHeaderTitle()
    {
        return $this->bloginfo['name'];
    }


    /**
     * Add a custom "h2" above the form.
     *
     * @access public
     */
    public function addNewHeaderTitle()
    {
        echo "<h2>{$this->bloginfo['name']}</h2>\n";
        echo "<h3>{$this->bloginfo['description']}</h3>\n";
    }


    /**
     * Login Name Confirmation - By default, the WordPress login screen will
     * inform you as to whether you have got the username or the password wrong.
     * This just insures there will be no specific information concerning the
     * username or password.
     *
     * Default WordPress message reads as thus:
     *   ERROR: The password you entered for the username {user} is incorrect.
     *
     * @return string
     * @access public
     */
    public function loginFailed()
    {
        return __('The login information you have entered is incorrect.', 'redress');
    }


    /**
     * Allow authentication by email address and timestamp login.
     *
     * @param string $user
     * @param string $username
     * @param string $password
     *
     * @return \WP_User
     * @access public
     */
    final public function loginEmailAuthentication($user, $username, $password)
    {
        if (!empty($username)) {
            $user = get_user_by('email', $username);
            if (isset($user, $user->user_login, $user->user_status) && 0 == (int) $user->user_status) {
                $username = strToLower($user->user_login);
            }
        }

        $authenticate = wp_authenticate_username_password(null, $username, $password);
        if (!isset($authenticate->errors) &&
            isset($authenticate->ID) &&
            in_array('account_manager', $authenticate->roles)
        ) {
            /**
             * Record when a user logs into the system.
             *
             * @param (int)    $user_id    (Required) User ID.
             * @param (string) $meta_key   (Required) Metadata key.
             * @param (mixed)  $meta_value (Required) Metadata value.
             * @param (mixed)  $prev_value (Optional) Previous value to check before removing. Default value: ''
             *
             * @see https://developer.wordpress.org/reference/functions/update_user_meta/
             */
            update_user_meta($authenticate->ID, 'last_login', current_time('mysql', 1));
        }

        return $authenticate;
    }


    /**
     * Modify the string of the login page to prompt for username/email address.
     *
     * @access public
     */
    final public function loginWithUsernameOrEmail()
    {
        if ('wp-login.php' !== basename($_SERVER['SCRIPT_NAME'])) {
            return;
        }

        $uname = esc_js(__('Username', 'redress'));
        $emailAddress = esc_js(__('Email Address', 'redress'));

        echo <<<JS
    <script>
if (document.getElementById('loginform')) {
    document.getElementById('loginform')
        .childNodes[1].childNodes[1].childNodes[0]
        .nodeValue = '{$emailAddress}';
}

if (document.getElementById('login_error')) {
    document.getElementById('login_error').innerHTML = document
        .getElementById('login_error').innerHTML
        .replace('{$uname}','{$emailAddress}');
}
    </script>
JS;
    }
}

/* <> */
