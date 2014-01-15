#!/bin/bash
if [ ! -d "translations" ]; then
        mkdir "translations"
fi
if [ ! -d "translations/ios/files" ]; then
	mkdir "translations/ios"
	mkdir "translations/ios/files";
	printf "NO ios/files"
fi
if [ ! -d "translations/android/files" ]; then
        mkdir "translations/android"
        mkdir "translations/android/files";
        printf "NO android/files"
fi
if [ ! -d "translations/yaml/files" ]; then
        mkdir "translations/yaml"
        mkdir "translations/yaml/files";
        printf "NO yaml/files"
fi
php smartling_download.php
