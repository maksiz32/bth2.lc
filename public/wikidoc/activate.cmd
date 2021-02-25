if "%ProgramFiles(x86)%"=="" (
  cd /d "%ProgramFiles%\Microsoft Office\Office14"
) else (
  cd /d "%ProgramFiles(x86)%\Microsoft Office\Office14"
)
cscript ospp.vbs /sethst:rgs-kms-03.rgs.ru
cscript ospp.vbs /act