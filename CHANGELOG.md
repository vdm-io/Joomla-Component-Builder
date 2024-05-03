# v4.0.0-rc4

- Improved the Schema Table update engine (more).
- Fix autoloader timing, and loading.
- Implement the Joomla Powers in JCB code, to move away from JClasses.
- Remove the SQL update, to only use the Schema updates of table columns to avoid collusion.
- Fix the admin.css file loading on dashboard. #1112
- Fix dynamic get data-type default to 0. #1110
- Fix the missing model call. #1114

# v4.0.0-beta

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

# v4.0.0-alpha

- First alpha release of Component Builder towards Joomla 4 (very unstable...)
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

# v3.2.0

- Fix #1053 so that the right and left tabs display correctly in Joomla 4&5
- Move the old helper compiler files to powers
- Move the old helper extrusion files to powers
- Add Preferred Joomla Version to Components
- Add custom file file mapping for Joomla 4 and 5
- Fix the plug-in installer script builder bug #1068
- Fix Event triggers for Joomla 4 and 5 builds.
- Fix plugin field selection
- Fix plugin params tab layout
- Add issue templates
- Force autoloader to always load
- Add Factory class to the J5 Event class. #1093
- Fix [Set String Value] in placeholder table to store the value as a base64 string.
- Fix the search area layout.
- Fix the search area code line selection.
- Fix the input edit button for custom fields.
- Add the new layout to list fields (GUI UPDATE)