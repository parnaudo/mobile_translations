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
#php smartling_download.php
cd ..
sh mobile_translations/ios_copy.sh

cp mobile_translations/translations/yaml/* ../SmugChatRuby/config/locales/
cd SmugChatRuby/config/locales/
