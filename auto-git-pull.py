"""
This script is used to pull the latest version of the code from the git repository.

Its purpose is to be run like a cron job (which is not possible on this productionserver) 
every 5 minutes to ensure that the code is always up to date.

Author: Karsten Reitan Sørensen, AARHUSTECH
Date: 31. january 2023
"""

# Import libraries
import os
import time
import datetime

DEBUG = True
    
# Define the path to the git repository
path = "/var/www/cloud" # "/home/username/website"

# Define the path to the log file
log_path = "/var/www/cloud/logs/auto-git-pull.log" # "/home/username/website/logs/auto-git-pull.log"

# Define the time between each pull
time_between_pulls = 30 # 5 minutes (5 * 60 seconds)

# Define the time between each log
time_between_logs = time_between_pulls # 3600 = 1 hour

## code that set up time variables and make git pull based on time
last_pull = 0
last_log = 0    
while True:
    if time.time() - last_pull > time_between_pulls:
        last_pull = time.time()
        print("cd " + path + " && git stash && git pull") if (DEBUG) else None
        os.system("cd " + path + " && git pull")
    # Log the time of the pull
    if time.time() - last_log > time_between_logs:
        last_log = time.time()
        print("Auto git pull at " + str(datetime.datetime.now()) + "") if (DEBUG) else None
        with open(log_path, "a") as f:
            f.write("Auto git pull at " + str(datetime.datetime.now()) + "")
            
            






