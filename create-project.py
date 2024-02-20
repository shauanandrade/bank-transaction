import subprocess

subprocess.run(["docker", "exec", "-it","app-test","composer","create-project","--prefer-dist","laravel/lumen","src"])
subprocess.run(["docker", "exec", "-it","app-test","php","-S","0.0.0.0:8000","-t","src/public"])