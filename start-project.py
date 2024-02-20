import subprocess
subprocess.run(["docker", "exec", "-it","app-test","php","-S","0.0.0.0:8000","-t","src/public"])