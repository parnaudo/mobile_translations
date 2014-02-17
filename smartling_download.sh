#!/bin/bash
if [ ! -d "translations" ]; then
        mkdir "translations"
fi
if [ ! -d "translations/ios/files" ]; then
	mkdir "translations/ios"
	printf "NO ios/files"
fi
if [ ! -d "translations/android/files" ]; then
        mkdir "translations/android"
        printf "NO android/files"
fi
if [ ! -d "translations/yaml/files" ]; then
        mkdir "translations/yaml"
        printf "NO yaml/files"
fi
#get new files from smartling
php smartling_download.php
#copy over android
sh android_copy.sh
#copy over ios annoying because files don't match up with folders
sh ios_copy.sh
#copy over ruby files
cp translations/yaml/* ../SmugChatRuby/config/locales/
