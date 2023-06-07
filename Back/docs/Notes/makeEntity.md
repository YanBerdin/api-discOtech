# MAKE:ENTITY

## ALBUM

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. FiercePopsicle):
 > Album

 created: src/Entity/Album.php
 created: src/Repository/AlbumRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > name

 Field type (enter ? to see all types) [string]:
 > ?

Main types
  * string
  * text
  * boolean
  * integer (or smallint, bigint)
  * float

Relationships / Associations
  * relation (a wizard 🧙 will help you build the relation)
  * ManyToOne
  * OneToMany
  * ManyToMany
  * OneToOne

Array/Object Types
  * array (or simple_array)
  * json
  * object
  * binary
  * blob

Date/Time Types
  * datetime (or datetime_immutable)
  * datetimetz (or datetimetz_immutable)
  * date (or date_immutable)
  * time (or time_immutable)
  * dateinterval

Other Types
  * ascii_string
  * decimal
  * guid


 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Album.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > edition

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/Album.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > releaseDate

 Field type (enter ? to see all types) [string]:
 > date

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Album.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > createdAt

 Field type (enter ? to see all types) [datetime_immutable]:
 > datetime

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Album.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > updatedAt

 Field type (enter ? to see all types) [datetime_immutable]:
 > datetime

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/Album.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

```

## SONG

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. AgreeableKangaroo):
 > Song

 created: src/Entity/Song.php
 created: src/Repository/SongRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > title

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Song.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > duration

 Field type (enter ? to see all types) [string]:
 > integer

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Song.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > preview

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/Song.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
```

## SUPPORT

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. GrumpyPopsicle):
 > Support

 created: src/Entity/Support.php
 created: src/Repository/SupportRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > name

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Support.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

```

## ARTIST

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. TinyPizza):
 > Artist

 created: src/Entity/Artist.php
 created: src/Repository/ArtistRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > fullname

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Artist.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

```

## STYLE

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. GentleChef):
 > Style

 created: src/Entity/Style.php
 created: src/Repository/StyleRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > name

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Style.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > image

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/Style.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

```

## USER

```bash
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. GentleChef):
 > Style

 created: src/Entity/Style.php
 created: src/Repository/StyleRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > name

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Style.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > image

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/Style.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
student@teleporter:/var/www/html/Apotheose/projet-disc-otech-back/Back$ bin/console make:entity

 Class name of the entity to create or update (e.g. VictoriousPuppy):
 > User

 created: src/Entity/User.php
 created: src/Repository/UserRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > email

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 180

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > role

 Field type (enter ? to see all types) [string]:
 > text

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > password

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > firstname

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > lastname

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > avatar

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > y

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration

```