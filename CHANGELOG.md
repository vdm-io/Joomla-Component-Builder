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