<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
final class SPG_Generator {
    private static function fields() {
        return array(
            'plugin_name' => array('Plugin name','The public name displayed in WordPress.','Example Plugin'),
            'plugin_slug' => array('Plugin slug','Lowercase letters, numbers and hyphens. Used for folder and ZIP names.','example-plugin'),
            'description' => array('Description','A brief description for the plugin header.','A lightweight WordPress plugin.'),
            'plugin_version' => array('Version','Initial semantic version.','1.0.0'),
            'plugin_uri' => array('Plugin URI','Optional homepage or WordPress.org plugin page URL.',''),
            'plugin_author' => array('Author','Displayed in the plugin header.','Simple Plugins'),
            'author_uri' => array('Author URI','Optional author website URL.','https://github.com/simplewpplugins'),
            'textdomain' => array('Text domain','Translation domain, usually identical to the plugin slug.','example-plugin'),
            'tags' => array('Tags','Comma-separated tags for the WordPress.org readme.','wordpress, plugin'),
            'plugin_namespace' => array('PHP namespace','PHP namespace for generated classes; nested namespaces are supported.','ExamplePlugin'),
            'plugin_main_class' => array('Main class','Main bootstrap class name; underscores are supported.','Example_Plugin'),
            'plugin_init_function' => array('Initialization function','Unique PHP function used to retrieve the main instance.','example_plugin'),
            'method_prefix' => array('Method prefix','Prefix for global helper functions.','example_plugin'),
            'constant_prefix' => array('Constant prefix','Uppercase prefix for PHP constants.','EXAMPLE_PLUGIN'),
            'plugin_required_wp_version' => array('Requires WordPress','Minimum WordPress version supported.','6.0'),
            'plugin_required_php_version' => array('Requires PHP','Minimum PHP version supported.','7.4'),
        );
    }
    private static function options() {
        return array(
            'actions'=>array('Actions class','Plugin hooks and activation/deactivation handlers.'),
            'enqueue'=>array('Enqueue class','Registers the selected frontend and admin assets.'),
            'helper'=>array('Helper class','Reusable helper methods.'),
            'shortcode'=>array('Shortcode class','A place to register plugin shortcodes.'),
            'admin'=>array('Admin class','Admin-specific functionality.'),
            'functions'=>array('Global helper functions','Optional includes/functions.php file.'),
            'frontend_css'=>array('Frontend CSS','Create a frontend stylesheet.'),
            'frontend_js'=>array('Frontend JavaScript','Create a frontend script.'),
            'admin_css'=>array('Admin CSS','Create an admin stylesheet.'),
            'admin_js'=>array('Admin JavaScript','Create an admin script.'),
            'templates'=>array('Templates directory','Include a templates directory with an index file.'),
            'languages'=>array('Languages directory','Include a translation directory; POT extraction should be done with WP-CLI.'),
            'publish'=>array('WordPress.org publishing assets','Include the existing publish/ directory with readme, license and sample graphics.'),
            'github'=>array('GitHub README and .gitignore','Include a basic README.md and .gitignore.'),
        );
    }
    public static function form() {
        if ( ! current_user_can( 'manage_options' ) ) { return '<p>You must be an administrator to use the plugin generator.</p>'; }
        $fields = self::fields(); $options = self::options();
        ob_start(); ?>
        <style>
        .spg-wrap{max-width:1000px;margin:24px auto;font:inherit;color:inherit}.spg-wrap *{box-sizing:border-box}.spg-wrap .spg-panel{background:#fff;color:#1d2939;border:1px solid #dce2e8;border-radius:12px;padding:24px;margin:18px 0;box-shadow:0 2px 8px #172b4d08}.spg-wrap h2{font-size:23px;margin:0 0 10px}.spg-wrap h3{font-size:17px;margin:0 0 15px}.spg-wrap .spg-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.spg-wrap label{display:block;font-weight:600;margin:0 0 5px}.spg-wrap input[type=text],.spg-wrap input[type=url],.spg-wrap textarea{width:100%;max-width:100%;padding:10px;border:1px solid #bfc9d4;border-radius:6px;background:#fff;color:#182230;font-size:14px}.spg-wrap .spg-help{display:block;color:#667085;font-size:12px;margin:5px 0 0;line-height:1.5}.spg-wrap .spg-option{padding:12px;border:1px solid #e4e7ec;border-radius:8px}.spg-wrap .spg-option label{display:flex;align-items:center;gap:9px;cursor:pointer}.spg-wrap .spg-option input{width:17px;height:17px}.spg-wrap .spg-submit{background:#175cd3;color:#fff;border:0;padding:13px 24px;border-radius:7px;cursor:pointer;font-weight:700;font-size:15px}.spg-wrap .spg-note{background:#eff8ff;border-left:4px solid #175cd3;padding:12px;margin:14px 0}.spg-wrap .spg-preview{background:#f8fafc;padding:14px;border-radius:8px;font-family:monospace;white-space:pre-wrap;font-size:12px;color:#344054}.spg-wrap .spg-error{color:#b42318}.spg-wrap .spg-muted{color:#667085}@media(max-width:650px){.spg-wrap .spg-grid{grid-template-columns:1fr}.spg-wrap .spg-panel{padding:16px}}
        </style>
        <div class="spg-wrap"><h2>Simple Plugin Generator</h2><p class="spg-muted">Build a consistent WordPress plugin starter, choose only the files you need, and download a ZIP. Nothing is installed into the plugins directory.</p>
        <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" id="spg-form">
        <input type="hidden" name="action" value="spg_download" /><?php wp_nonce_field('spg_download','spg_nonce'); ?>
        <section class="spg-panel"><h3>1. Plugin information</h3><div class="spg-grid">
        <?php foreach ( $fields as $key=>$field ) : ?>
        <div><label for="spg-<?php echo esc_attr($key); ?>"><?php echo esc_html($field[0]); ?></label>
        <?php if ($key === 'description') : ?><textarea id="spg-<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="3"><?php echo esc_textarea($field[2]); ?></textarea>
        <?php else : ?><input id="spg-<?php echo esc_attr($key); ?>" type="text" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($field[2]); ?>" <?php echo in_array($key,array('plugin_name','plugin_slug','plugin_namespace','plugin_main_class','plugin_init_function','method_prefix','constant_prefix'),true)?'required':''; ?> /><?php endif; ?>
        <small class="spg-help"><?php echo esc_html($field[1]); ?></small></div>
        <?php endforeach; ?></div></section>
        <section class="spg-panel"><h3>2. Classes, files and folders</h3><p class="spg-muted">Core bootstrap and autoloader are always included. Unchecked classes are omitted from the ZIP and from initialization.</p><div class="spg-grid">
        <?php foreach ($options as $key=>$option) : ?><div class="spg-option"><label><input type="checkbox" name="modules[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key,array('actions','enqueue','helper','shortcode','admin','functions','frontend_css','frontend_js','admin_css','admin_js','templates','languages','publish'),true)); ?> /><?php echo esc_html($option[0]); ?></label><small class="spg-help"><?php echo esc_html($option[1]); ?></small></div><?php endforeach; ?>
        </div><p class="spg-note">The <code>publish/</code> folder contains WordPress.org publishing materials. It is included in the source ZIP only when selected; remove it when packaging a final WordPress.org installable release.</p></section>
        <section class="spg-panel"><h3>3. Review and download</h3><p class="spg-muted">The preview updates as you change options.</p><pre class="spg-preview" id="spg-preview"></pre><button class="spg-submit" type="submit">Generate and download ZIP</button></section>
        </form></div>
        <script>(function(){const f=document.getElementById('spg-form'),p=document.getElementById('spg-preview');if(!f||!p)return;const update=()=>{const d=new FormData(f),slug=d.get('plugin_slug')||'plugin',mods=d.getAll('modules[]');let a=[slug+'/', '  '+slug+'.php','  includes/','    init.php'];for(const x of ['actions','enqueue','helper','shortcode'])if(mods.includes(x))a.push('    class-'+x+'.php');if(mods.includes('admin'))a.push('    admin/class-admin.php');if(mods.includes('functions'))a.push('    functions.php');for(const x of ['frontend_css','frontend_js','admin_css','admin_js'])if(mods.includes(x))a.push('  assets/'+(x.includes('css')?'css/':'js/')+(x.startsWith('admin')?'admin-':'')+slug+(x.includes('css')?'.css':'.js'));for(const x of ['templates','languages','publish'])if(mods.includes(x))a.push('  '+x+'/');if(mods.includes('github'))a.push('  README.md','  .gitignore');p.textContent=a.join('\n')};f.addEventListener('input',update);f.addEventListener('change',update);update();})();</script>
        <?php return ob_get_clean();
    }
    private static function fail($message) { wp_die(esc_html($message),'Plugin generation failed',array('response'=>400)); }
    private static function php_identifier($value) { return (bool) preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D',$value); }
    /**
     * Build the documented bootstrap for the generated plugin.
     *
     * Only selected components are initialized and exposed as accessors.
     *
     * @param array $data    Validated plugin configuration.
     * @param array $modules Selected component identifiers.
     * @return string Generated PHP source.
     */
    private static function bootstrap($data,$modules) {
        $ns = $data['plugin_namespace'];
        $class = $data['plugin_main_class'];
        $prefix = $data['constant_prefix'];
        $func = $data['plugin_init_function'];
        $slug = $data['plugin_slug'];
        $namespace_literal = var_export($ns . '\\', true);
        $code = strtr(<<<'PHP'
<?php
/**
 * Main plugin bootstrap and component loader.
 *
 * @package {{NAMESPACE}}
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin controller.
 *
 * Provides a single plugin instance, autoloads namespaced classes,
 * and initializes only the components included in this plugin.
 *
 * @since 1.0.0
 */
class {{CLASS}} {

    /**
     * Shared plugin instance.
     *
     * @since 1.0.0
     * @var self|null
     */
    private static $instance = null;

    /**
     * Initialized component instances, keyed by component name.
     *
     * @since 1.0.0
     * @var array
     */
    public $classes = array();

    /**
     * Autoload classes within the plugin namespace.
     *
     * Converts underscores in class names to hyphens in filenames,
     * e.g. User_Profile => includes/class-user-profile.php.
     * Nested namespaces map to subdirectories under includes/.
     *
     * @since 1.0.0
     * @param string $class_name Fully qualified PHP class name.
     * @return void
     */
    public static function autoload( $class_name ) {
        $namespace = {{NAMESPACE_LITERAL}};

        if ( 0 !== strpos( $class_name, $namespace ) ) {
            return;
        }

        $relative = substr( $class_name, strlen( $namespace ) );
        $parts    = explode( '\\', $relative );
        $name     = array_pop( $parts );
        $filename = 'class-' . strtolower( str_replace( '_', '-', $name ) ) . '.php';
        $folder   = $parts ? strtolower( implode( '/', $parts ) ) . '/' : '';
        $path     = {{PREFIX}}_PATH . 'includes/' . $folder . $filename;

        if ( is_readable( $path ) ) {
            require_once $path;
        }
    }

    /**
     * Retrieve the shared plugin instance.
     *
     * @since 1.0.0
     * @return self
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initialize the components selected during plugin generation.
     *
     * @since 1.0.0
     */
    private function __construct() {
PHP
        , array(
            '{{NAMESPACE}}' => $ns,
            '{{CLASS}}' => $class,
            '{{NAMESPACE_LITERAL}}' => $namespace_literal,
            '{{PREFIX}}' => $prefix,
        ) );

        $classes = array(
            'enqueue'   => array( 'Enqueue', 'enqueue' ),
            'shortcode' => array( 'Shortcode', 'shortcode' ),
            'actions'   => array( 'Actions', 'actions' ),
            'helper'    => array( 'Helper', 'helper' ),
            'admin'     => array( 'admin\\Admin', 'admin' ),
        );
        foreach ( $classes as $key => $component ) {
            if ( in_array( $key, $modules, true ) ) {
                $code .= "        \$this->{$component[1]}();\n";
            }
        }
        $code .= "    }\n\n";

        foreach ( $classes as $key => $component ) {
            if ( ! in_array( $key, $modules, true ) ) {
                continue;
            }
            $method = $component[1];
            $type = '\\' . $ns . '\\' . $component[0];
            $code .= "    /**\n     * Get the {$method} component, creating it on first use.\n     *\n     * @since 1.0.0\n     * @return {$type}\n     */\n";
            $code .= "    public function {$method}() {\n";
            $code .= "        if ( ! isset( \$this->classes['{$key}'] ) ) {\n";
            $code .= "            \$this->classes['{$key}'] = new {$type}();\n";
            $code .= "        }\n\n        return \$this->classes['{$key}'];\n    }\n\n";
        }

        $code .= strtr(<<<'PHP'
    /**
     * Load a plugin template, allowing the active theme to override it.
     *
     * Theme overrides live in the {{SLUG}}/ directory. The resolved
     * path is filterable for integrations with other plugins.
     *
     * @since 1.0.0
     * @param string $template Relative template path without .php.
     * @param array  $args     Variables made available to the template.
     * @return void
     */
    public function get_template_part( $template, $args = array() ) {
        $template = ltrim( str_replace( '..', '', $template ), '/' );
        $path     = get_stylesheet_directory() . '/{{SLUG}}/' . $template . '.php';

        if ( ! is_file( $path ) ) {
            $path = {{PREFIX}}_PATH . 'templates/' . $template . '.php';
        }

        $path = apply_filters( '{{SLUG}}_template', $path, $template );

        if ( is_file( $path ) ) {
            // Keep template variables scoped to this method.
            if ( is_array( $args ) ) {
                extract( $args, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
            }
            include $path;
        }
    }
}

// Register the autoloader before initializing plugin components.
spl_autoload_register( array( '{{CLASS}}', 'autoload' ) );

/**
 * Retrieve the main plugin instance.
 *
 * @since 1.0.0
 * @return {{CLASS}}
 */
if ( ! function_exists( '{{FUNCTION}}' ) ) {
    function {{FUNCTION}}() {
        return {{CLASS}}::instance();
    }
}

// Start the plugin.
{{FUNCTION}}();
PHP
        , array(
            '{{SLUG}}' => $slug,
            '{{PREFIX}}' => $prefix,
            '{{CLASS}}' => $class,
            '{{FUNCTION}}' => $func,
        ) );
        return $code;
    }
    private static function enqueue($data,$modules) {
        $ns=$data['plugin_namespace'];$slug=$data['plugin_slug'];$prefix=$data['constant_prefix'];$ver=$data['plugin_version'];
        $code="<?php\nnamespace {$ns};\nif ( ! defined( 'ABSPATH' ) ) { exit; }\nclass Enqueue {\n    public function __construct() {\n";
        if(array_intersect(array('frontend_css','frontend_js'),$modules))$code.="        add_action( 'wp_enqueue_scripts', array( \$this, 'frontend_assets' ) );\n";
        if(array_intersect(array('admin_css','admin_js'),$modules))$code.="        add_action( 'admin_enqueue_scripts', array( \$this, 'admin_assets' ) );\n";
        $code.="    }\n    public function frontend_assets() {\n";
        if(in_array('frontend_css',$modules,true))$code.="        wp_enqueue_style( '{$slug}-style', {$prefix}_URL . 'assets/css/{$slug}.css', array(), ".var_export($ver,true)." );\n";
        if(in_array('frontend_js',$modules,true))$code.="        wp_enqueue_script( '{$slug}-script', {$prefix}_URL . 'assets/js/{$slug}.js', array(), ".var_export($ver,true).", true );\n";
        $code.="    }\n    public function admin_assets() {\n";
        if(in_array('admin_css',$modules,true))$code.="        wp_enqueue_style( '{$slug}-admin-style', {$prefix}_URL . 'assets/css/admin-{$slug}.css', array(), ".var_export($ver,true)." );\n";
        if(in_array('admin_js',$modules,true))$code.="        wp_enqueue_script( '{$slug}-admin-script', {$prefix}_URL . 'assets/js/admin-{$slug}.js', array(), ".var_export($ver,true).", true );\n";
        return $code."    }\n}\n";
    }
    public static function download() {
        if ( ! current_user_can('manage_options') ) { self::fail('Permission denied.'); }
        if ( ! isset($_POST['spg_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['spg_nonce'])),'spg_download') ) { self::fail('Security check failed.'); }
        if ( ! class_exists('ZipArchive') ) { self::fail('PHP ZipArchive extension is required.'); }
        $data=array();foreach(self::fields() as $key=>$field){$value=isset($_POST[$key]) && is_scalar($_POST[$key])?wp_unslash($_POST[$key]):$field[2];$data[$key]=sanitize_text_field($value);}
        $data['plugin_slug']=sanitize_title($data['plugin_slug']);
        if(!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D',$data['plugin_slug']))self::fail('Invalid plugin slug.');
        foreach(array('plugin_main_class','plugin_init_function','method_prefix','constant_prefix') as $key)if(!self::php_identifier($data[$key]))self::fail('Invalid PHP identifier: '.$key);
        foreach(explode('\\',$data['plugin_namespace']) as $part)if(!self::php_identifier($part))self::fail('Invalid namespace.');
        if($data['plugin_name']==='')self::fail('Plugin name is required.');
        if(!preg_match('/^[0-9]+(?:\.[0-9]+){1,3}(?:[-.][A-Za-z0-9.-]+)?$/D',$data['plugin_version']))self::fail('Invalid version number.');
        if(!preg_match('/^[0-9]+(?:\.[0-9]+){1,2}$/D',$data['plugin_required_wp_version']) || !preg_match('/^[0-9]+\.[0-9]+$/D',$data['plugin_required_php_version']))self::fail('Invalid minimum version.');
        if($data['plugin_uri']!==''&&!wp_http_validate_url($data['plugin_uri']))self::fail('Invalid plugin URI.');
        if($data['author_uri']!==''&&!wp_http_validate_url($data['author_uri']))self::fail('Invalid author URI.');
        $data['textdomain']=sanitize_title($data['textdomain']);if(!$data['textdomain'])$data['textdomain']=$data['plugin_slug'];
        $modules=isset($_POST['modules']) && is_array($_POST['modules'])?array_map('sanitize_key',wp_unslash($_POST['modules'])):array();$modules=array_values(array_intersect($modules,array_keys(self::options())));
        if(array_intersect(array('frontend_css','frontend_js','admin_css','admin_js'),$modules)&&!in_array('enqueue',$modules,true))$modules[]='enqueue';
        $replacement=array();$mapping=array('plugin_description'=>'description','plugin_author_uri'=>'author_uri');foreach($data as $key=>$value){$replacement['[{('.$key.')}]']=$value;}foreach($mapping as $placeholder=>$key)$replacement['[{('.$placeholder.')}]']=$data[$key];
        $zip=new ZipArchive();$temp=wp_tempnam('spg-'.$data['plugin_slug'].'.zip');if(!$temp)self::fail('Cannot allocate a temporary file.');
        if($zip->open($temp,ZipArchive::OVERWRITE)!==true){@unlink($temp);self::fail('Cannot create ZIP.');}
        $slug=$data['plugin_slug'];$root=__DIR__.'/../master-copy';$add=function($name,$content)use($zip,$slug){if(!$zip->addFromString($slug.'/'.$name,$content))throw new RuntimeException('Cannot add file: '.$name);};
        try {
            $main=file_get_contents($root.'/main.txt');$main=strtr($main,$replacement);$main=str_replace("include {$data['constant_prefix']}_PATH.'includes/functions.php';",in_array('functions',$modules,true)?"include {$data['constant_prefix']}_PATH.'includes/functions.php';":'', $main);
            $add($slug.'.php',$main);$add('index.php',"<?php // Silence is golden.\n");$add('includes/index.php',"<?php // Silence is golden.\n");$add('includes/init.php',self::bootstrap($data,$modules));
            $classfiles=array('actions'=>'includes/class-actions.txt','helper'=>'includes/class-helper.txt','shortcode'=>'includes/class-shortcode.txt','admin'=>'includes/admin/class-admin.php');
            foreach($classfiles as $key=>$path){if(in_array($key,$modules,true)){$content=file_get_contents($root.'/'.$path);$add(preg_replace('/\.txt$/','.php',$path),strtr($content,$replacement));}}
            if(in_array('enqueue',$modules,true))$add('includes/class-enqueue.php',self::enqueue($data,$modules));
            if(in_array('functions',$modules,true))$add('includes/functions.php',strtr(file_get_contents($root.'/includes/functions.txt'),$replacement));
            foreach(array('frontend_css'=>'assets/css/'.$slug.'.css','frontend_js'=>'assets/js/'.$slug.'.js','admin_css'=>'assets/css/admin-'.$slug.'.css','admin_js'=>'assets/js/admin-'.$slug.'.js') as $key=>$path){if(in_array($key,$modules,true))$add($path,"/* {$data['plugin_name']} */\n");}
            if(in_array('templates',$modules,true))$add('templates/index.php',"<?php // Silence is golden.\n");
            if(in_array('languages',$modules,true))$add('languages/index.php',"<?php // Generate translations using wp i18n make-pot.\n");
            if(in_array('github',$modules,true)){$add('README.md','# '.$data['plugin_name']."\n\n".$data['description']."\n");$add('.gitignore',".DS_Store\n/vendor/\n/node_modules/\n");}
            if(in_array('publish',$modules,true)){
                $iterator=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/publish',FilesystemIterator::SKIP_DOTS));
                foreach($iterator as $file){if(!$file->isFile()||strpos($file->getFilename(),'._')===0||$file->getFilename()==='.DS_Store')continue;$relative='publish/'.substr($file->getPathname(),strlen($root.'/publish/'));$content=file_get_contents($file->getPathname());if(pathinfo($relative,PATHINFO_EXTENSION)==='txt')$content=strtr($content,$replacement);$add($relative,$content);}
            }
            $zip->close();
            if(!is_file($temp)||filesize($temp)===0)throw new RuntimeException('ZIP is empty.');
            while(ob_get_level()>0)ob_end_clean();
            nocache_headers();header('Content-Type: application/zip');header('Content-Disposition: attachment; filename="'.$slug.'.zip"');header('Content-Length: '.filesize($temp));header('X-Content-Type-Options: nosniff');readfile($temp);@unlink($temp);exit;
        } catch(Throwable $e){$zip->close();@unlink($temp);self::fail($e->getMessage());}
    }
}
