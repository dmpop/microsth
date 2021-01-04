# micro.sth

micro.sth stands for _micro something_ or _micro stash_. It is a minimalist tool written in PHP that can be used for maintaining a personal microblog, drafting articles, keeping notes, managing tasks, and more. micro.sth stores content in plain text files.

## Features

- Markdown support
- Password protection
- Support for multiple pages
- Publish individual pages
- Images are resized to a specified size during upload

## Dependencies

- PHP 7.x or higher
- PHP7 GD extension
- Apache or any other web server

# Installation and usage

1. Use the `git clone https://gitlab.com/dmpop/microsth.git` commmand to fetch micro.sth.

2. Open the _microsth/config.php_ file and edit the default values.

3. Save the changes and close the file. Upload the entire _microsth_ folder to the document directory of your web server.

## Working with pages

When you open micro.sth for the first time, it automatically creates the default page specified in the _config.php_ file and an accompanying _.md_ file in the _content_ directory. For example, the default value of the `$first_page` variable is set to _home_. When you open micro.sth, it creates the **Personal** page and the _content/personal.md_ file.

You can add as many pages as you need, and there are two ways to add a page:

1. If the `$newpage` parameter in the _config.php_ file is set to _true_, enter the desired page name into the **Page name** field  and press the **New Page** button.

2. Create an _.md_ file in the _content_ directory.

Keep in mind that page names are case-sensitive.

How you choose to use pages is up to you. For example, you might want to create a separate page for each year (2020, 2019, 2018, and so on). Alternatively, you can create pages for specific types of content (e.g., links, quotes, snippets. etc.) or different kinds of activities (e.g., travel, hacking, photography, etc.).

### Publish pages

If you enabled password protection, you can make individual pages publicly available. To do this, open the desired page for editing and press the **Publish** button. You can then access the page either by going to _https://127.0.0.1/microsth/pub.php_ and selecting the published page from the **Pages** list, or by pointing the browser the direct link _https://127.0.0.1/microsth/pub.php?page=PAGENAME_ (where _PAGENAME_ is the actual name of the published page). To unpublish a published page, use the **Unpublish** button in the edit area.

If the `$trash` parameter in the _config.php_ file is set to _true_, you can use the **Trash** button to remove the currently viewed page. Keep in mind that this doesn't delete the page but moves it to the _trash_ directory.

## Problems?

Please report bugs and issues in the [Issues](https://github.com/dmpop/microsth/issues) section.

## Contribute

If you've found a bug or have a suggestion for improvement, open an issue in the [Issues](https://github.com/dmpop/microsth/issues) section.

To add a new feature or fix issues yourself, proceed as follows.

1. Fork the project's repository.
2. Create a feature branch using the `git checkout -b new-feature` command.
3. Add your new feature or fix bugs and run the `git commit -am 'Add a new feature'` command to commit changes.
4. Push changes using the `git push origin new-feature` command.
5. Submit a pull request.

## Author

Dmitri Popov [dmpop@linux.com](mailto:dmpop@linux.com)

## License

The [GNU General Public License version 3](http://www.gnu.org/licenses/gpl-3.0.en.html)