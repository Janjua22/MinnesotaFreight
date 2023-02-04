<style>
    :root {
        /* Main colors */
        --custom-primary-color: {{ siteSetting('primary') }};
        --custom-secondary-color: {{ siteSetting('secondary') }};
        --custom-success-color: {{ siteSetting('success') }};
        --custom-info-color: {{ siteSetting('info') }};
        --custom-warning-color: {{ siteSetting('warning') }};
        --custom-danger-color: {{ siteSetting('danger') }};
        --custom-light-color: {{ siteSetting('light') }};
        --custom-dark-color: {{ siteSetting('dark') }};
        
        /* Background colors */
        --custom-logo-background-color: {{ siteSetting('logo_background') }};
        --custom-side-bar-color: {{ siteSetting('sidebar_background') }};
        --custom-header-color: {{ siteSetting('header_background') }};
        --custom-side-bar-active: {{ siteSetting('sidebar_active') }};

        /* Active colors */
        --custom-primary-light:{{ siteSetting('primary_light') }};
        --custom-secondary-light:{{ siteSetting('secondary_light') }};
        --custom-success-light:{{ siteSetting('success_light') }};
        --custom-info-light:{{ siteSetting('info_light') }};
        --custom-warning-light:{{ siteSetting('warning_light') }};
        --custom-danger-light:{{ siteSetting('danger_light') }};
        --custom-dark-light:{{ siteSetting('dark_light') }};

        /* Hover colors */
        --custom-secondary-active:{{ siteSetting('secondary_active') }};
        --custom-primary-active:{{ siteSetting('primary_active') }};
        --custom-success-active:{{ siteSetting('success_active') }};
        --custom-info-active:{{ siteSetting('info_active') }};
        --custom-warning-active:{{ siteSetting('warning_active') }};
        --custom-danger-active:{{ siteSetting('danger_active') }};
        --custom-light-active: {{ siteSetting('light_active') }};
        --custom-dark-active:{{ siteSetting('dark_active') }};
    }
</style>