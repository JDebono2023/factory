> # Factory CMS - CMS for Bright Sign

Data management system created for The Factory. CMS designed to permit the Factory users the ability to add and schedule images for display on thier Bright Sign based signage.
 
> ## Project Details
- dev: J.Debono
- initialized: April 18, 2024
- launch date: June, 2024
- repo: Factory-CMS
- elm bucket: elm-clientapps/factory *see filesystems.php for custom driver details
- HTML:
    - file: FactoryCustomImage.html
    - deployed to Bright Sign
    - repo: Factory-html
- APIs used in html:
    - versiondata (version control)
    - mediadata (content for display)


> ## Content Scheduler
- uses Laravel Task Scheduler & Windows native Task Scheduler
    - Windows Task Scheduler File: Factory Custom Image Scheduler 
    - Laravel: app/Commands/EventScheduler.php
        - controls the triggering of the Scheduler
        - updates version control after successful completion of the scheduler tasks
- task runs on minute intervals
- client requirement: 
    - add and manage media for display at specific hours over the day
    - images are turned off and on via the scheduler, or can be manually turned off and on, as needed

- Windows Scheduler Set-Up 
    - Factory Custom Image Scheduler
    - Triggers: On A Schedule, Daily, recur every 1 day, Repeat task every 1 minute, for a duration of 1 day
    - Settings: Allow task to be run on demand, Run task asap after a scheduled start is missed, Run a new instance in parallel
    

> ## Database Details

| Primary Table      | Secondary Table        | Relationship                |
| :----------------- | :--------------------- | :--------------             |
| media              | schedules              | 1:M media_id                |
| schedules          |                        |                             |
| version            |                        |                             |

- Versioning: 
    - activity tracked: app/Observers/SchedulesObserver.php
    - crud actions on scheduler trigger versioning update
    - scheduling actions are captured directly in the custom artisan command - see app/Console/Commands/EventScheduler.php for details

> ## Teams & Authentication Details
- roles: 
    - ELM master Admin: elm (Administrator)
    - Factory Users: factory (Factory)
- adding users to teams is done by invite to team only. Individuals can not self register
- individual user teams are disabled
- users are managed via app/HTTP/Livewire/AllUser.php 

> ## Permissions - See App/Policies 
- ELM: full privileges, views & manages all content, teams, users
- Factory: partial privileges, view and manage Factory users, CRUD access on media content and scheduling
- ELM: user_id 1: provides master access as owner, no other ELM users required
- registration link is hidden
- guest users/registered but not assigned to a team users are redirected to log-in when attempting to access any other page


