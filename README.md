# micro.sth

micro.sth stands for _micro something_ or _micro stash_. It is a minimalist tool written in PHP that can be used for keeping a personal microblog, drafting articles, keeping notes, and whatnot. micro.sth stores content in plain text files. micro.sth supports Markdown and provides simple password protection. If you add a _random.md_ file with a list of phrases or quotes, micro.sth will display them randomly. micro.sth also allows you to upload images and resize them on-the-fly.

## Dependencies

- PHP 7.x or higher
- PHP7 GD extension
- Apache or any other web server

# Installation and usage

Open the _config.php_ file and edit the default values. To replace the default gravatar with your own, replace the _https://icotar.com/avatar/monkey.png_ value of the `$gravatar` variable with a Gravatar link as follows:

    'gravatar' => 'http://www.gravatar.com/avatar/' . md5("dmpop@linux.com") . '?s=96';

Save the changes and close the file.

To run micro.sth locally, run the `php -S 0.0.0.0:8000` command and point your browser to *localhost:8000*

To deploy micro.sth on a web server, move the *microsth* directory to the document root of the server. Point your browser to *127.0.0.1/microsth* (replace *127.0.0.1* with the actual IP adress or domain name of your server).

## Working with pages

When you open micro.sth for the first time, it automatically creates the default page specified in the _config.php_ file and an accompanying _.md_ file in the _content_ directory. For example, the default value of the `$first_page` variable is set to _personal_. When you open micro.sth, it creates the **Personal** page and the _content/personal.md_ file.

You can add as many pages as you need, and there are two ways to add a page:

1. Create an _.md_ file manuall in the _content_ directory.

2. Append `?page=name` to the URL of your micro.sth instance, for example: *https://127.0.0.1/microsth/?category=travel* 

How you choose to use pages is up to you. For example, you might want to create a separate page for each year (2020, 2019, 2018, and so on). Alternatively, you can create pages for specific types of content (e.g., links, quotes, snippets. etc.) or different kinds of activities (e.g., travel, hacking, photography, etc.).
