# v5.0.1-alpha7

- Add push options to Joomla Power
- Complete the Joomla Power Init and Reset features
- Fix Gitea Contents class functions
- Last Alpha release (feature block)

# v5.0.1-alpha

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

# v4.0.0

- Fix the plug-in installer script builder bug #1067
- Fix Event triggers for Joomla 4 and 5 builds.
- Add fix to the update script, so that upgrading JCB from Joomla 3 to 4 will not fail.
- Fix plugin field selection
- Fix plugin params tab layout
- Add issue templates
- Force autoloader to always load. 
- Fix repeatable layout #1076
- Add Factory class to the J5 Event class. #1093
- Fix customfilelist field to conform to the new namespacing conventions. #1094
- Add menus for languages, servers, get snippets to J4 #1095
- Fix [Set String Value] in placeholder table to store the value as a base64 string.
- Fix the search area layout.
- Fix the search area code line selection.
- Fix the input edit button for custom fields.
- Add the new layout to list fields (GUI UPDATE)
- Start fixing the field view in Joomla 4. #1096
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

# v3.2.1

- Add power path override option on component level.
- Fix the sql build feature. #1032
- Add view list and single name fix.
- Add component code name fix.
- Add reset list of powers.
- Fix missing Factory class in plugin. #1102
- Fix plugin code display when methods and properties are missing.
- Add Joomla powers for namespace dynamic management.
- Add fallback option to ensure that all JCB tables and fields exist.
- Move the powers autoloader to its own file.
- Fix the media field size limitation. #1109
- Add dynamic datatype update to schema field check.
- Fix version_update column size.
- Improved the Schema Table update engine.
- Improved the Schema Table update engine (more)
- Fix autoloader timing, and loading.
- Implement the Joomla Powers in JCB code, to move away from JClasses.
- Remove many of the SQL updates, to only use the Schema updates of table columns to avoid collusion.
- Fix the admin.css file loading on dashboard. #1112
- Fix the missing model call. #1114
- Fix the wrong $date call. #1115
- Add the BaseDatabaseModel use statement to custom site view controller. #1119
- Fix the customfolderlist field. #1120