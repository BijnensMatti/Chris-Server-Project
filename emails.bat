@echo off
	
for /f "skip=1" %%x in ('wmic os get localdatetime') do if not defined MyDate set MyDate=%%x
set today=%MyDate:~6,2%%MyDate:~4,2%
	
SET filenametowrite=emails%today%
	
break>%filenametowrite%.txt
	
setlocal EnableDelayedExpansion
set "string=abcdefghijklmnopqrstuvwxyz"
	
Set "proxlist=words.txt"

For /F "Tokens=1* Delims=:" %%a In ('FindStr/N "^" "%proxlist%"') Do (
	Set "line[%%a]=%%b"
	Set "total=%%a"
)

for /l %%x in (1, 1, 100) do (
		 set /a randnumber=!random! %% %total%
		(call echo %%x. %%line[!randnumber!]%%@%today%.com) >> %filenametowrite%.txt		
)

rem exit
