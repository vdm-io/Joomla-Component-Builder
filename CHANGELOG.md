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
- Changed all CSS and JS to use `JHtml::_(` instead of `$this->document->` in compiler code.
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