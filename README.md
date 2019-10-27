# micro.sth

micro.sth stands for _micro something_ or _micro stash_. It is a minimalist tool written in PHP that can be used for keeping a personal microblog, drafting articles, keeping notes, and whatnot. micro.sth stores content is in a plain text file. The tool supports Markdown and automatically paginates long texts. micro.sth also provides simple password protection and backup functionality. If you add a _random.md_ file with a list of phrases or quotes, micro.sth will display them randomly. micro.sth also allows you to upload images and resize them on-the-fly.

## Dependencies

- PHP 7.x or higher
- PHP7 GD extension
- Apache or any other web server (optional)

# Installation and usage

Open the _config.php_ file and edit the default values. To replace the default gravatar with your own, replace the _https://icotar.com/avatar/monkey.png_ value of the `$gravatar` variable with a Gravatar link as follows:

    'gravatar' => 'http://www.gravatar.com/avatar/' . md5("dmpop@linux.com") . '?s=96';

Save the changes and close the file.

To run micro.sth locally, run the `php -S 0.0.0.0:8000` command and point your browser to *localhost:8000*

To deploy micro.sth on a web server, move the *microsth* directory to the document root of the server. Point your browser to *127.0.0.1/microsth* (replace *127.0.0.1* with the actual IP adress or domain name of your server).
