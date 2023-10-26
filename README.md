## What is ModelsKit Database

The aim of this project is to have a multi users management tool for managing plastik models kits.

The original project is developped with React and Node, this one is full PHP but is the same.


### V1.3a

Features
==

List of Models : You can add new models, countries, builders, kits brands, scale, etc... in order to have a list of all models on the market.

Your account : You can modify your datas, avatar. You can also manage your providers, yours orders. When adding an order, the model will automatically be added to your stock. You can also see statistics of your stock.

Social network : you can see others users (if they allow to be seen), use messages to talk with them and see they're finished models. You can also let a message on their builds, and see the messages they let on your own.

Your stock : You can manage your models' kit stock (liked, ordered, on shell, on workbench or finished). You have also a random kit chooser. For finished kits, you can upload up to 4 pictures.



Install
==

Copy all files in the www directory of your web server (which must be apache in order to work well).

Copy config.xml.sample or rename it config.xml and fill it with your infos (DB credentials, email).

Then, go to {yourSite}/init to initialize database and create admin account. If all is right, then you can use the site.

