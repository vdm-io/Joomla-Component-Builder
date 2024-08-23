# v5.0.3-alpha3

- Fix usergrouplist compiler triggers. #1100
- Add field type power integration [init, reset, push]

# v5.0.3-alpha

- Add push option to powers area
- Fix library save as copy error. #1162
- Fix the error when no components exists. #1164
- Fix search page error due to File class.

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

# v4.0.2

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

# v3.2.3

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
- Keep jQuery in dynamicGet area for Joomla 3
- Add native plugin builder for Joomla 4 & 5