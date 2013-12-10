#!/bin/bash
printf "\nrunning on $(date -u)"
cd ios
printf "\nSyncing ios"
git pull origin master
printf "\ncurling ios"
curl -F "file=@/root/translations/ios/SmugChat/Base.lproj/Localizable.strings;type=text/plain" "https://api.smartling.com/v1/file/plupload?apiKey=fdc6e190-e855-4588-bfe0-74b7006aeab1&projectId=59d739850&fileUri=%2Ffiles%2FLocalizable_final.strings&fileType=IOS&approved=1"
cd ../android
printf "\nSyncing Android"
git pull origin master
printf "\ncurling android"
curl -F "file=@/root/translations/android/res/values/strings.xml;type=text/xml" "https://api.smartling.com/v1/file/plupload?apiKey=fdc6e190-e855-4588-bfe0-74b7006aeab1&projectId=59d739850&fileUri=/files/android.xml&fileType=android&approved=1"
cd ../ruby	
printf "\nSyncing Ruby"
git pull origin master
printf "\nCurling Ruby"
curl -F "file=@/root/translations/ruby/config/locales/en.yml;type=text/plain" "https://api.smartling.com/v1/file/plupload?apiKey=fdc6e190-e855-4588-bfe0-74b7006aeab1&projectId=59d739850&fileUri=/files/en.yml&fileType=YAML&approved=1"
