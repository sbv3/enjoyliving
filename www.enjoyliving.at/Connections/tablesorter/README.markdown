tablesorter is a jQuery plugin for turning a standard HTML table with THEAD and TBODY tags into a sortable table without page refreshes.
tablesorter can successfully parse and sort many types of data including linked data in a cell.

### Documentation

* See the [full documentation](http://mottie.github.com/tablesorter/docs/).
* All of the [original document pages](http://tablesorter.com/docs/) have been included.
* Information from my blog post on [undocumented options](http://wowmotty.blogspot.com/2011/06/jquery-tablesorter-missing-docs.html) and lots of new demos have also been included.
* Change log moved from included text file into the [wiki documentation](https://github.com/Mottie/tablesorter/wiki/Change).

### Demos

* [Basic alpha-numeric sort Demo](http://mottie.github.com/tablesorter/).
* Links to demo pages can be found within the main [documentation](http://mottie.github.com/tablesorter/docs/).
* More demos & playgrounds - updated in the [wiki pages](https://github.com/Mottie/tablesorter/wiki).

### Features

* Multi-column alphanumeric sorting.
* Multi-tbody sorting - see the [options](http://mottie.github.com/tablesorter/docs/index.html#options) table on the main document page.
* Parsers for sorting text, alphanumeric text, URIs, integers, currency, floats, IP addresses, dates (ISO, long and short formats) &amp; time. [Add your own easily](http://mottie.github.com/tablesorter/docs/example-parsers.html).
* Support for ROWSPAN and COLSPAN on TH elements.
* Support secondary "hidden" sorting (e.g., maintain alphabetical sort when sorting on other criteria).
* Extensibility via [widget system](http://mottie.github.com/tablesorter/docs/example-widgets.html).
* Cross-browser: IE 6.0+, FF 2+, Safari 2.0+, Opera 9.0+.
* Small code size.
* Works with jQuery 1.2.6+ (jQuery 1.4.1+ needed with some widgets).

### Licensing

* Copyright (c) 2007 Christian Bach.
* Original examples and docs at: [http://tablesorter.com](http://tablesorter.com).
* Dual licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) and [GPL](http://www.gnu.org/licenses/gpl.html) licenses.

### Change Log

View the [complete listing here](https://github.com/Mottie/tablesorter/wiki/Change).

#### Version 2.4.1 (9/29/2012)

* Fixed uitheme widget:
  * A second div is now wrapped around the table cell contents.
  * This allows using relative &amp; absolute positioning on the content as Firefox does not support this directly on table cells.
* Fixed support for jQuery v1.2.6
  * Core modified to not use `closest()` function.
  * Resizable widget modified to not use `closest()` &amp `isEmptyObject` functions.

#### Version 2.4 (9/27/2012)

* Core changes:
  * Table bodies are now detached before processing the contents. There is a noticable speed increase when sorting large tables, especially in IE. Fix for [issue #72](https://github.com/Mottie/tablesorter/issues/72) and possibly [issue #75](https://github.com/Mottie/tablesorter/issues/75).
  * Changed `cssChildRow` option default from `expand-child` to `tablesorter-childRow` to make it more clear.
  * Changed `selectorHeaders` option default from `'> thead th'` to `'> thead th, > thead td' to include non-header cells.
  * Fixed `sortAppend` being applied multiple times when sorting multiple columns. Fix for [issue #115](https://github.com/Mottie/tablesorter/issues/115).
  * Fixed `updateCell` method to correctly target the table cell from the cache.
  * Fixed something, somewhere to fix [issue #128](https://github.com/Mottie/tablesorter/issues/128) LOL... darn you IE!
  * Updated the `widthFixed` option to set the column widths as a percentage instead of pixels to better resize the table dynamically.
  * Updated the script so that data-column attributes are no longer removed from disabled columns. This fixes an issue where `filter-false` doesn't apply to disabled columns.
  * Updated the `widgets` option so that the order of widgets no longer matters. The array now is sorted in reverse alphabetical order, but the zebra widget is always applied last. [See the table here](http://mottie.github.com/tablesorter/docs/index.html#Widget-options).
  * Updated the `$.tablesorter.isDigit()` function to ensure that no errors pop up when giving it an element of type number. Fix for [issue #121](https://github.com/Mottie/tablesorter/pull/121).
  * Updated the natural sort function to better sort numbers with leading zeros. See [this issue](https://github.com/overset/javascript-natural-sort/issues/6) for more details.
  * Updated the code to always check that the `sortList` option contains numeric values. See [issue #127](https://github.com/Mottie/tablesorter/issues/127).
  * Updated the date parser to not be so rigid. See [issue #125](https://github.com/Mottie/tablesorter/issues/125).
  * Updated several internal functions to keep tablesorter compatible with jQuery 1.2.6. Fixs [issue #124](https://github.com/Mottie/tablesorter/issues/124).
  * Tablesorter can no longer be initialized multiple times on the same table, unless the destroy method is called.
  * Bound events now have `unbind` executed before `bind` to fix an issue with Microsoft ajax.net. See [issue #119](https://github.com/Mottie/tablesorter/issues/119).

  * Added `cssHeaderRow` option
      * This option contains the class name added to the header row.
      * Previously it got the same class name as `cssHeader`.
      * Default value is `"tablesorter-headerRow"`.

  * Added `cssIcon` option:
      * This option contains the class name added to the &lt;i&gt; element that is now automatically added to every header cell.
      * To prevent the plugin from adding an &lt;i&gt; element to the headers, set this option to an empty string.
      * Default value is `"tablesorter-icon"`.

  * Added `theme` option & new themes!
      * Default theme is now `default`.
      * Note that ALL of the documentation demos now need the theme option set to `"blue"` to apply the blue theme.
      * Thanks to [thezoggy](https://github.com/thezoggy), numerous themes have been added including default, ice, black-ice, dark &amp; dropbox.
      * Updated hovered row styling to include child rows in some themes (blue, green and less themes).
      * See the column widget update for details on styling of the thead and tfoot cells as well.
      * Removed the blue and green zipped theme files.

  * Added `selectorSort` option:
      * This option allows you to set which element within the table header triggers the sort.
      * Previously the entire header cell would trigger a sort so any extra elements within the cell would not be clickable.
      * See [issue #137](https://github.com/Mottie/tablesorter/issues/137).

  * Added `cssProcessing` option:
      * When true, an indeterminate progress icon is added to the header while tablesorter is sorting or filtering columns.
      * It is disabled by default, but can be enabled by setting the `showProcessing` option to `true`.
      * The icon can also be shown using the API: `$.tablesorter.isProcessing(table, toggle, $ths);`
          * The `table` parameter is the table to target.
          * `toggle` is a boolean which when `true` will add the `cssProcessing` option class name to the header.
          * The last parameter `$ths` is optional. When set it will target specific header cells. If undefined, only the sorted headers will be targetted.
      * Note that for small tables, this processing icon may quickly flash and may be distracting. In larger tables, it will be more visible, but may not animate. I believe this is because of all the javascript processing going on (single threaded) prevents the animation from occurring - I'll try to find a better solution.

* Parsers:
  * All parsers now have publically available methods.
  * Access the parsers using `$.tablesorter.parsers`.
  * Get the desired parser code using `parser = $.tablesorter.getParserById("parser_name")`.

* Widgets:
    * All widgets now have publically available methods:
    * Access the widgets using `$.tablesorter.widgets`.
    * Get the desired widget code using `$.tablesorter.getWidgetById("widget_name")`.
    * Apply all selected widgets from the `widgets` option directly using `$.tablesroter.applyWidget(table, initialize);`, where `initialize` is a boolean indicating to run the widget's `init` function versus the `format` function. This is the same as triggering [applyWidgets](file:///C:/Repos/tablesorter/docs/index.html#applywidgets) on the table.
    * All widgets now have a `remove` function which when called will remove the widget from the table, see the [writing custom widgets](http://mottie.github.com/tablesorter/docs/example-widgets.html) demo page for an example.
    * Updated the `destroy` method to call all widget's remove function, if it exists.
    * Added a method to refresh widgets:
      * Trigger this method using `$('table').trigger('refreshWidgets', [doAll, dontapply]);`, or call it directly using `$.tablesorter.refreshWidgets(table, doAll, dontapply)`
      * If `doAll` is `true` it removes all widgets from the table. If `false` only non-current widgets (from the `widgets` option) are removed.
      * When done removing widgets, the widget re-initializes the currently selected widgets, unless the `dontapply` parameter is `true` leaving the table widget-less.
      * Note that if the `widgets` option has any named widgets, they will be re-applied to the table when it gets resorted. So if you want to completely remove all widgets from the table, also clear out the widgets option `$('table')[0].config.widgets = [];`
      * Enhancement request from [issue #112](https://github.com/Mottie/tablesorter/issues/112).
    * Added a [jQuery compatibility table](http://mottie.github.com/tablesorter/docs/#Widget-options) to the WidgetOptions section to show the limitations of each widget. See [issue #124](https://github.com/Mottie/tablesorter/issues/124).

* Columns widget updates:
  * The column class names from the `widgetOptions.columns` option can now be applied to the header row (including the sticky header) and footer row.
  * Added a new option named `columns_thead` which is `true` by default. Set it to `false` to not add the columns class name to the header.
  * Added a new option named `columns_tfoot` which is `true` by default. Set it to `false` to not add the columns class name to the footer.
  * In addition to the column class name, the tfoot also gets the class name for an ascending or desending sort obtained from the `cssAsc` and `cssDesc` option.
  * Added a remove function method.

* Filter widget changes:
    * Added the ability to enter operators into the filter. Added `< <= >= > ! =`.
      * To find values greater than 10, enter `>10`.
      * To find letters less than M, enter `<m`, but to find letters greater than M, enter `>=n`, because `>m` will include `ma` because `ma > m`.
      * To find people that aren't George, enter `!George` or to only look for males, enter `!female`. This doesn't work in the quick search filter because
      * Exact matches can be done using quotes, as before, or by using an equal sign `=`, e.g. find the exact number 10 by using `10=`.
      * **Note #1** In currency, percent or other numerical columns with numbers, the operators will ignore these extra symbols when parsing the value. So to find values greater than 10%, ignore the percent sign and use `> 10`.
      * **Note #2** when using any of the above operators, the child row content is ignored even if `filter_childRows` is set to `true`.

    * Added `filter_columnFilters` option which when `true` will add a filter to each column. If `false`, no filter row is added.
    * Added `filter_hideFilters` option which when `true` will hide the filter row initially. The rows is revealed by hovering over the filter row or giving any filter input/select focus.
    * Added `filter_reset` option which will contain a jQuery selector pointing to a reset element (button or link).

    * Added `filter_useParsedData` option
      * When `true`, ALL filter searches will only use parsed data.
      * To only use parsed data in specific columns, set this option to `false` and use any of the following methods (they all do the same thing), in order of priority:
        * jQuery data `data-filter="parsed"`.
        * metadata `class="{ filter: 'parsed'}"`. This requires the metadata plugin.
        * headers option `headers : { 0 : { filter : 'parsed' } }`.
        * header class name `class="filter-parsed"`.
      * Remember that parsed data most likely doesn't match the actual table cell text, `20%` becomes `20` and `Jan 1, 2013 12:01 AM` becomes `1357020060000`.
      * Enhancement request from [issue #96](https://github.com/Mottie/tablesorter/issues/96).

    * Added a method to apply a filter to the table when `filter_columnFilters` is `false` by triggering a search on the table.

        ```javascript
        // search using an array - the index of the array matches the column index
        // [ column0, column1, column2, ..., columnN ]
        var columns = []; // undefined array elements are treated as an empty search ''
        columns[4] = '2?%'; // is equivalent to defining the array this way [ '', '', '', '2?%' ]
        $('table').trigger('search', [columns]);
        ```

    * Added "filterInit" triggered event on the table after the filter widget has finished initializing.
    * Added "filterStart" triggered event on the table. Enhancement request from [issue #108](https://github.com/Mottie/tablesorter/issues/108).
    * Added "filterEnd" triggered event on the table. This is used by the updated pager plugin to allow it to work with the filter widget. Enhancement request from [issue #108](https://github.com/Mottie/tablesorter/issues/108).

    * Modified filter select dropowns (still added by using `filter-select` or setting a `filter_functions` column to `true`):
      * By default the select will filter exact matches. To only match column content, add a "filter-match" class to the column. Fixes [issue #102](https://github.com/Mottie/tablesorter/issues/102).
      * The contents of the select are now alphanumerically sorted. Fixes [issue #103](https://github.com/Mottie/tablesorter/issues/103).

    * The filter widget should properly target columns when multiple header rows with column and row spans are included. Fixes [issue #113](https://github.com/Mottie/tablesorter/issues/113).
    * Added a remove function method.

* Resizable widget update
  * Added an option `resize` to `widgetOptions`
    * When `false` the resized columns widths will not save to storage (localStorage/cookie).
    * Default is `true` which saves resized column widths.
  * Modified the resize method to smooth out the resizing.
  * Right clicking (opening the context menu) on the header will now reset the resizing of the columns. If you right-click on the header with no resized columns, the context menu will open as it normally does.
  * Added a remove function method.

* saveSort widget update
  * Added an option `saveSort` to `widgetOptions`
    * When `false` the saved sort in storage (localStorage/cookie) will still apply to the table upon initialization, but any new sorts will not save.
    * Default is `true` which loads the saved sort on initialization and saves, and overwrites, any new sorts of the table.
    * Added a remove function method which only clears the saved sort.

* Sticky Headers Widget update
  * This widget now clones the entire thead for stickyfying ( yes, I know that isn't a real word :P ). This is a similar method used by [jmosbech](https://github.com/jmosbech) in his [StickyTableHeaders plugin](https://github.com/jmosbech/StickyTableHeaders).
  * Header rows containing column and row spans should now correctly align.
  * Attempted to correct the border spacing issue in non-webkit browsers. It's not perfect, so this may be tweaked in the future to make it pixel perfect, if that is ever possible.
  * Added a remove function method.

* UITheme widget updated to be more generalized:
  * This widget will now apply a jQuery UI or Bootstrap theme. It was designed to me extendable to other platforms.
  * Added a [Bootstrap](http://mottie.github.com/tablesorter/docs/example-widget-bootstrap-theme.html) theme demo. This demo also includes the filter widget with the pager plugin to show their interaction and other styling possibilities.
  * To extend the uitheme widget to other platforms, add/extend the theme in the `$.tablesorter.themes` variable contained in the jquery.tablesorter.widgets.js file.
  * To add either a jQuery UI or Bootstrap theme to the table, set it up as follows (also see the [jQuery UI](http://mottie.github.com/tablesorter/docs/example-widget-ui-theme.html) or [Bootstrap](http://mottie.github.com/tablesorter/docs/example-widget-bootstrap-theme.html) demo):

    ```javascript
    $("table").tablesorter({
      // widget code now contained in the jquery.tablesorter.widgets.js file
      widgets : [ 'uitheme', 'zebra' ],
      widgetOptions : {
        // set the uitheme widget to use the jQuery UI theme class names ## NEW ##
        uitheme : 'jui' // or 'bootstrap'
      }
    });
    ```

    * The `widgets` option must include the `uitheme` widget.
    * The `widgetOptions` for `uitheme` now only contains the name of the platform to use (previously it was the 3 icon class names to use). For now, use either `jui` for jQuery UI or `bootstrap` for a Twitter Bootstrap theme.
  * I am working on changing tablesorter's core to do all of this automatically, so if it works out it will be available in tablesorter version 3 and this widget will be obsolete.
  * Bootstrap theme enhancement requested in [issue #104](https://github.com/Mottie/tablesorter/issues/104).
  * Added a remove function method.

* Zebra widget updates:
  * It will no longer apply to nested tables. Fix for [issue #98](https://github.com/Mottie/tablesorter/issues/98) and also fixed by [styson](https://github.com/styson) in [issue #116](https://github.com/Mottie/tablesorter/pull/116). Thanks!
  * The zebra widget is needed if using the bootstrap striped theme. See the [Bootstrap](http://mottie.github.com/tablesorter/docs/example-widget-bootstrap-theme.html) demo for an example. Fixes [issue #111](https://github.com/Mottie/tablesorter/issues/111).
  * The tbody is no longer hidden (or removed) when applying row class names. It appears to not change the speed significantly. But please feel free to report any speed issues.
  * Added a remove function method.

* Pager addon changes:
    * The pager plugin now plays nice with the filter widget.
    
    Fixes [issue #6](https://github.com/Mottie/tablesorter/issues/6).
    * Added `cssGoto` option which contains a jQuery selector pointing to a page select dropdown. Updated the pager demo with an example.
    * Updated pager addong to now work with the filter and advanced filter widgets.
    * Added `{filteredRows}` and `{filteredPages}` parameters to the `output` option. They contain the number of rows and pages that result from the filter widget search.

* Updated the `jquery.metadata.js` file to the latest version and modified the code to better work with JSHint.

#### Version 2.3.11 (7/12/2012)

* Merged in [mmeisel](https://github.com/mmeisel)'s `ipAddress` parser fix. Optimized the format code.
* Merged in two fixes from [wwalser](https://github.com/wwalser). Thanks for finding and fixes this issue!
* Made the sort functions public. This is in anticipation of using the natural sort function in the filter widget to sort select options.

#### Version 2.3.10 (6/21/2012)

* Fixed the filter widget causing an error when initialized on an empty table. Fixes [issue #95](https://github.com/Mottie/tablesorter/issues/95). Thanks to [Raigen](https://github.com/Raigen) for all of the diligent testing!

#### Version 2.3.9 (6/21/2012)

* Theme updates:
  * Modified the blue & green themes to make the column colors better match the header.
  * Added row hovered styling.
  * Added a `theme.less` file which is set up to allow you to set a one color to create a palette of colors for even and odd rows, columns widget styling and row hovered colors.
* Modified `update`, `updateCell` and `addRows` methods:
  * An `updateComplete` event is now fired after each method has completed.
  * Added a callback to each method. Used as follows:

    ```javascript
    var resort = true, // resort table using the current sort
        callback = function(table){
            alert('new sort applied');
        };
    $("table").trigger("update", [resort, callback]);
    ```

* Added a callback to the `sorton` method. It is used as follows:

    ```javascript
    var sort = [[0,0],[2,0]],
        callback = function(table){
            alert('new sort applied to ' + table.id);
        };
    // Note that the sort value below is inside of another array (inside another set of square brackets)
    // A callback method was added in 2.3.9.
    $("table").trigger("sorton", [sort, callback]);
    ```

* Fixed isDigit function returning true on an empty string. Fix for [issue #88](https://github.com/Mottie/tablesorter/issues/88).
* Fixed filter widget:
  * Filter inputs in multiple thead rows now correctly correspond to the column.
  * Fixed filtering of child rows to use the `filter_ignoreCase` option.
  * Fixed child rows displaying incorrectly when not filtered. Fix for [issue #89](https://github.com/Mottie/tablesorter/issues/89).
  * The default filter select will now properly update after an update event. Fix for [issue #91](https://github.com/Mottie/tablesorter/issues/91).
* Fixed `sortList` to prevent errors. Fix for [issue #92](https://github.com/Mottie/tablesorter/issues/92).
* Fixed `onRenderHeader` option missing the last column. Fix for [issue #93](https://github.com/Mottie/tablesorter/issues/93), and thanks to [OBCENEIKON](https://github.com/OBCENEIKON) for the fix!

#### Version 2.3.8 (6/5/2012)

* Filter widget search will now update on table updates. Fix for [issue #86](https://github.com/Mottie/tablesorter/issues/86).
* Fixed errors when entering invalid regex into the filter widget search input. Fix for [issue #87](https://github.com/Mottie/tablesorter/issues/87).
* Removed unnecessary semi-colons from the unicode characters in the [sorting accented characters demo](http://mottie.github.com/tablesorter/docs/example-locale-sort.html).
* Added a [Language](https://github.com/Mottie/tablesorter/wiki/Language) wiki page which contains the character equivalent code for different languages (well only for Polish so far).
