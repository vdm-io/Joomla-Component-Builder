# v5.0.3

- Add [push] option to powers area.
- Fix error in [Save As Copy] functionality for the library. #1162
- Fix error when no components exist. #1164
- Fix search page error caused by File class.
- Fix UserGroupList compiler triggers. #1100
- Add power integration field type with [init, reset, push] options.
- Fix default database fields to allow NULL values. #1169
- Fix power list field to support search functionality. #1167
- Expand Demo component in JCB v4 to include advanced features.
- Fix missing working path in zip creation.
- Fix dynamic retrieval for the demo site view.
- Fix demo site view to display files.
- Fix field type initialization message.
- Fix type-agnostic comparisons by casting to CHAR in dynamic get joins.
- Fix dynamic download for site area to use correct namespace.
- Fix missing edit button on fields in related views.
- Fix dashboard display issues.
- Restore search option in the [use] field for related views.
- Fix namespace issue causing linker to break.

# v5.0.2

- Fix site view form missing classes in J4+
- Fix permissions tab in items in J4+
- Fix site display controller checkEditId function in J4+
- Add class methods to the HtmlView classes in J4+
- Fix broken toolbar call in HtmlView in J4+
- Fix missing scripts and styles fields and methods in the site admin view model
- Update subform field layout across JCB for cleaner look
- Remove expansion feature
- Fix helper area
- Fix database mySql update in J4+
- Remove phpspreadsheet completely from Joomla 4+
- Add option to use powers in preflight event in the installer class
- Fix abstract schema class function check default index warring
- Fix dynamicGet so that the table values will load again. #1155
- Add more pure JS to the dynamic get area
- Add native plugin builder for Joomla 4 & 5
- Add basic API for admin views

# v5.0.1

- Fix auto build from SQL in Joomla 5.
- Fix permission issue for admin views.
- Add in JCB gitea push feature to help maintain JCB core features.
- Add extending options to interfaces.
- Change the extendsinterfaces field to allow null, #1139
- Update the Schema class to also update null mismatching if needed
- Add repositories for better integration with gitea
- Refactored the Data classes
- Add new Data classes
- Add new subform classes
- Fix registry class methods return type
- Update all list and custom fields to use the new layouts
- Add push options to Joomla Power
- Complete the Joomla Power Init and Reset features
- Fix Gitea Contents class functions
- Fix subform set methods
- Improved the Joomla Power Push path
- Fix the metadata, metadesc, metakey database issue
- Fix function mismatch call in the compiler power class.
- Fix init feature to only add missing powers
- Fix controller postSaveHook function, for correct model class in Joomla 4 and 5
- Fix app instances (mismatch) in the install script and schema class when installing from CLI
- Add option to use placeholders in Joomla Power namespaces.
- Fix subform layout of uikit in JCB

# v5.0.0

- Fix the plug-in installer script builder bug #1067
- Fix Event triggers for Joomla 4 and 5 builds.
- Add fix to the update script, so that upgrading JCB from Joomla 4 to 5 will not fail.
- Fix plugin field selection
- Fix plugin params tab layout
- Add issue templates
- Force autoloader to always load
- Fix repeatable layout #1076
- Add Factory class to the J5 Event class. #1093
- Fix customfilelist field to conform to the new namespacing conventions. #1094
- Add menus for languages, servers, get snippets to J5 #1095
- Fix [Set String Value] in placeholder table to store the value as a base64 string.
- Fix the search area layout.
- Fix the search area code line selection.
- Fix the input edit button for custom fields.
- Add the new layout to list fields (GUI UPDATE)
- Start fixing the field view in Joomla 5. #1096
- Add power path override option on component level.
- Fix the sql build feature. #1032
- Add the compiler menu back.
- Fix the CustomfolderlistField #1094
- Add view list and single name fix.
- Add component code name fix.
- Add reset list of powers.
- Add Joomla powers for namespace dynamic management.
- Add fallback option to ensure that all JCB tables and fields exist.
- Move the powers autoloader to its own file.
- Fix the media field size limitation. #1109
- Add dynamic datatype update to schema field check.
- Fix version_update column size.
- Improved the Schema Table update engine.
- Improved the Schema Table update engine (more).
- Fix autoloader timing, and loading.
- Implement the Joomla Powers in JCB code, to move away from JClasses.
- Remove the SQL update, to only use the Schema updates of table columns to avoid collusion.
- Fix the admin.css file loading on dashboard. #1112
- Fix dynamic get data-type default to 0. #1110
- Fix the missing model call. #1114
- Fix the wrong $date call. #1115
- Add the BaseDatabaseModel use statement to custom site view controller. #1119
- Fix the customfolderlist field. #1120

# v4.0.3

- Add [push] option to powers area.
- Fix [Save as Copy] error in library. #1162
- Fix error when no components exist. #1164
- Fix search page error caused by File class.
- Fix usergrouplist compiler triggers. #1100
- Add power field type integration [init, reset, push].
- Fix default database fields to allow NULL. #1169
- Fix power list field to enable search. #1167
- Expand the Demo component in JCB v4 to include more advanced features.
- Fix missing working path in zip process.
- Fix dynamic get issue in demo site view.
- Fix demo site view to display files.
- Fix field type init message.
- Ensure type-agnostic comparisons by casting to CHAR in joins for dynamic get.
- Fix dynamic download for site area with correct namespace.
- Fix missing edit button on fields in related views.
- Fix dashboard display.
- Restore search option in [use] field of related views.
- Fix namespace issue that broke the linker.

# v3.2.4

- Add [push] option to Powers area.
- Fix [Save As Copy] error in library. #1162
- Fix error when no components exist. #1164
- Fix search page error caused by File class.
- Fix UserGroupList compiler triggers. #1100
- Add Power field type integration: init, reset, push.
- Fix database default fields to allow NULL. #1169
- Fix Power List field to allow searching. #1167
- Remove Demo component from JCB v3; add Hello World component as demo.
- Fix missing working path in ZIP.
- Fix demo site view to display files.
- Fix message for Field Type init.
- Ensure type-agnostic comparisons by casting to CHAR in joins for dynamic retrieval.
- Fix dynamic download in site area with correct namespace.
- Fix missing edit button on fields in related views.
- Fix dashboard display issues.
- Re-add search option in use field of related views.
- Fix namespace issue that broke the linker.