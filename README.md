Requirements
---

* PHP 7.1 or higher;
* PHP extensions: Ctype, iconv, JSON, PCRE, Session, SimpleXML, and Tokenizer;
* Composer;
* Web-server;

 Installation
 ---
 
 * Clone project from GitHub;
 * Execute `composer install` in project directory;
 * Configure your web-server;
   * Set document root: `_path_to_project_dir_/public`
   * Set default location "/" to `_path_to_project_dir_/public/index.php`
   * For example, here my configuration file for Nginx:
   ```smartyconfig
    server {
        charset utf-8;
        client_max_body_size 128M;
        listen 80;
    
        server_name news.need;
        root /home/achaplygin/projects/News-Need/public;
    
        location / {
            try_files $uri /index.php$is_args$args;
        }
    
        location ~ ^/index\.php(/|$) {
            include fastcgi_params;
            fastcgi_index  index.php?$args;
            fastcgi_pass unix:/run/php-fpm/www.sock;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
    
        location ~ \.php$ {
            return 404;
        }
    
        error_log /home/achaplygin/projects/logs/news_need/error.log;
        access_log /home/achaplygin/projects/logs/news_need/access.log;
    }
    ```
 About
---

This application can receive news from external sites and display them in a minimalistic way.
To receive news, you should select one of the sources from the drop-down list and click "Load".

---

The application code structure is in the src directory.
There is one controller, one entity that is used as a Data Transfer Object, and one form for receiving requests from the user.
The main logic in the services. Here is realized ServiceFactory, generating instances of specific NewsServices depending on the parameters received from the form.
Each of NewsServices extends common abstract Service which implements NewsInterface. 
