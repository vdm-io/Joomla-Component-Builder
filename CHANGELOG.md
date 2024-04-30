# v3.2.1-rc2

- Improved the Schema Table update engine (more)
- Fix autoloader timing, and loading.
- Implement the Joomla Powers in JCB code, to move away from JClasses.
- Remove many of the SQL updates, to only use the Schema updates of table columns to avoid collusion.

# v3.2.1-beta

- Add fallback option to ensure that all JCB tables and fields exist.
- Move the powers autoloader to its own file.
- Fix the media field size limitation. #1109
- Add dynamic datatype update to schema field check.
- Fix version_update column size.
- Improved the Schema Table update engine.

# v3.2.1-alpha

- Add power path override option on component level.
- Fix the sql build feature. #1032
- Add view list and single name fix.
- Add component code name fix.
- Add reset list of powers.
- Fix missing Factory class in plugin. #1102
- Fix plugin code display when methods and properties are missing.
- Add Joomla powers for namespace dynamic management.

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

# v3.2.0-beta

- Add namspace prefix to both global, and component override level.
- Add Joomla 4 and 5 build option
- Add joomla_version to custom code.
- Add Joomla 4 and 5 correct build files.
- Fix #1026 by removing chosen everywhere.
- Resolve #1028 by adding in line helper toggle integration to all admin views.
- Remove the import and export buttons until the area is fixed.
- Add emptystate list template to all admin list views.
- Fix #1026 by adding the correct layout to the filter views.
- Fix #1026 by adding the class to the filter views.
- Fix #1026 by adding a hint to the filters that are having multiple selection.
- Fix the directional bog where a field in the filters are also called direction.
- Fix the getModel helper method fot J4+.
- Fix the AjaxController contructor class.
- Improved the getModel calls from the AxajController class.
- Improve the Joomla 4 Templates.
- Fix #1033 the response class issue for the gitea classes.
- Remove the JRegistry class to resolve #1036, #1035
- Move the defined or die below use statements.
- Add the new router view
- Fix #1041 so that custom tabs are build correctly.
- Fix #1043 so that delete function in Joomla 4 and 5 will work.
- Fix #1045 so that plug-in Structure::setMainXmlFile method will except an object.
- Fix #1042 so that it will remove line breaks and new lines from other languages as well.
- Fix #1046 so that the version restore function will work.
- Fix #1051 making sure the list view is lowercase.
- Fix #1052 so that tabs last opened is remembered and opened again on save, refresh or reopening of an item.
- Fix #1057 so that the datetime fields will be set correctly in mysql.
- Fix #1055 to add the style and scripts to all views.
- Move beta to main repo

# v3.1.28

- Adds better remote repository management for the super power features.
- Fixes #1014 so that powers are added to components.
- Updates PHPSecLib.
- Fixed connection failure to remote server.
- Adds overriding of back-folder and git-folder on component level.

# v3.1.26

- Fixed changelog direction so newest changes is listed at top of the file.
- Finished the init function of super powers.
- Adds rest function inside super power.
- Adds super powers to all templates.
- Updates many helper class methods to now use the utility classes.
- Adds the `spl_autoload_register` method to the component entry file (as-well).
- Moved most methods from the compiler fields class to powers. #955
- Refactored many new builder classes from the registry class.
- Converted the Content class to two builder classes.
- Adds option to add additional templates to a module.
- Resolves #1002 by adding STRING instead of WORD.
- Ported the FOF encryption class into Powers. https://git.vdm.dev/joomla/fof
- Changed all CSS and JS to use `Html::_(` instead of `$this->document->` in compiler code.
- Adds option to turn jQuery off if UIKIT 3 is added.
- Adds option to auto write injection boilerplate code in Powers area.
- Adds option to auto write service provider boilerplate code in the Powers area.
- Improved the `getDynamicContent` method and all banner locations to fetch from https://git.vdm.dev/joomla/jcb-external/ instead.
- Major stability improvements all over the new powers complier classes.
- New [base Registry class](https://git.vdm.dev/joomla/super-powers/src/branch/master/src/7e822c03-1b20-41d1-9427-f5b8d5836af7) has been created specially for JCB.
- Remember to update all plug-ins with this version update (use the package).

# v3.1.24

- Fix the update server #978 issue.
- Fixed the change log to load all entries, not just the last one.
- Fixed #983 so that database updates are created when adding a new adminview
- Moved a few builder arrays to the Compiler Registry
- Adds super powers to JCB
- Adds Gitea API library
- Improves Power filters
- Fix #991 to add the Utilities service class
- Adds Superpower Key (SPK) replacement feature
- Adds Superpower search (GREP) feature
- Adds Power Insert/Update Classes
- Fix #995 that all update sites are using the correct URL

# v3.1.19

- We fixed #972 so that custom code (in the header) will be added after the power namespaces
- We added a message to show when a server move failed
- We fixed the BaseConfig to not use '_' as separator
- We fixed the footable loading issue
- We removed the need for passing placeholders by reference
- We added the option to generate a CHANGELOG
- We fixed the server class to load new client if server details changed.
- We fixed the readme placeholder issue #978.
- We fixed the empty server url issue #978.
- Fixed Package import to now use the phplibsec version 3