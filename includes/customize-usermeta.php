<?php
namespace Simple_Handbook;

class Customize_usermeta {
    public function __construct()
    {
        add_action( 'show_user_profile', [$this, 'shb_usermeta_form_field_birthday']);
        add_action( 'edit_user_profile', [$this, 'shb_usermeta_form_field_birthday'] );
        add_action( 'personal_options_update', [$this, 'shb_usermeta_form_field_birthday_update'] );
        add_action( 'edit_user_profile_update', [$this, 'shb_usermeta_form_field_birthday_update'] );

        add_action( 'init', [$this, 'shb_simple_user_role'] );
    }

    /**
     * The field on the editing screens.
     * @param $user WP_User object
     */
    public function shb_usermeta_form_field_birthday($user) {
        ?>
            <table class="shb-form-field form-table">
                <tr>
                    <th>
                        <label for="birthday">
                            <?php esc_html_e('Birthday', 'simple-handbook'); ?>
                        </label>
                    </th>
                    <td>
                        <input 
                        type="date"
                        class="regular-text ltr shb-birthday-field"
                        id="birthday"
                        name="birthday"
                        value="<?php echo esc_attr(get_user_meta($user->ID, 'birthday', true)); ?>"
                        >
                        <p class="description">
                            <?php esc_html_e('Select Your birthday date', 'simple-handbook'); ?>
                        </p>
                    </td>
                </tr>
            </table>
        <?php
    }

    /**
     * The save action.
     * @param $user_id int the ID of the current user.
     * @return bool Meta ID if the key didn't exist, true on successful update, false on failure
     */
    public function shb_usermeta_form_field_birthday_update($user_id) {
        // check that the current user have the capability to edit the $user_id
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        // create/update user meta for the $user_id
        return update_user_meta(
            $user_id,
            'birthday',
            $_POST['birthday']
        );
    }


    /**
     * Adding User Roles
     */
    public function shb_simple_user_role() {
        add_role( 
            'simple_role',
            __('Simple Role', 'simple-handbook'),
            array(
                'read'         => true,
                'edit_posts'   => true,
                'upload_files' => true,
            )
        );
    }
}