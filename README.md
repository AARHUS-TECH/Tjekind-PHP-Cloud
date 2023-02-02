# Tjekind Cloud

Koden er taget fra det oprindelige Tjekind system

Formålet er at opgradere Tjekind for at indhente data fra flere forskellige autonome enheder

## Dependencies

* Bootstrap 5.2 <br />Ref: [Get started with Bootstrap](https://getbootstrap.com/docs/5.2/getting-started/introduction/)
* jQuery 3.6.3 <br />Ref: [jQuery](https://jquery.com/)
* Popper 2.11.6 <br />Ref: [TOOLTIP & POPOVER POSITIONING ENGINE](https://popper.js.org/)

## Todo

* [ ] Håndtering af Regioner / zoner
* [ ] Læse NFC kort direkte fra browser side

## Tjekind IoT cloudserver and frontend app

```

project-root/
  .git/            # Git configuration and source directory
  assets/          # Uncompiled/raw CSS, LESS, Sass, JavaScript, images
  bin/             # Command line scripts
  config/          # Application configuration
  node_modules/    # Node.js modules for managing front end
  public/          # Publicly accessible files at http://example.com/
      index.php    # Main entry point - front controller
      ...
  src/             # PHP source code files
      Controller/  # Controllers
      ...
  templates/       # Template files
  tests/           # Unit and functional tests
  translations/    # Translation files
      en_US.yaml
  var/             # Temporary application files
      cache/       # Cache files
      log/         # Application specific log files
  vendor/          # 3rd party packages and components with Composer
  .gitignore       # Ignored files and dirs in Git (node_modules, var, vendor...)
  composer.json    # Composer dependencies file
  phpunit.xml.dist # PHPUnit configuration file

```

## Remote request fra Tjekind systemer

Kørsel af request forudsætter adgang til internettet

### Funktionen består at 2 filer: en klasse fil og siden som modtager data og giver resultatet i en JSON fil

Class: RemoteAccess.php
Frontend: remoteRequest.php8

### Funktionen tilgåes gennem
  https://cloud.ats-skpdatait.dk/admin/remoteRequest.php

### Urlen indeholder følgende felter i GET eller POST HTTP request

| GET/POST var       | Funktion                                                |
| ------------------ | ------------------------------------------------------- |
| $userID            | Bruger ID fra den oprindelige database                  |
| $groupID           | Gruppe ID som adskiller elever i <br />regioner / zoner |
| $fornavn           | Fornavn(e)                                              |
| $efternavn         | Efternavn                                               |
| $status            | Status: enum '0', '1', '2'                              |
| $tjekind_timestamp | MySQL current_timestamp()                               |
| $iSKP              | iSKP enum '0', '1'                                      |
| $bemning           | Årsag til fravær: enum: <br />'Syg',<br />'Ekstern Opgave',<br />'Job | Samtale',<br />'Forsinket',<br />'Ikke Godkendt',<br />'Andet',<br />'Datastue',<br />'Ulovlig fravær',<br />'Ferie / Fridag',<br />'?',<br/>'Corona' |
| $action            | Mulighed for at styre handling af data                  |
| $token             | Token fra Tjekind enheden                               |




# Getting Started with Create React App

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

## Available Scripts

In the project directory, you can run:

### `yarn start`

Runs the app in the development mode.\
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.

The page will reload when you make changes.\
You may also see any lint errors in the console.

### `yarn test`

Launches the test runner in the interactive watch mode.\
See the section about [running tests](https://facebook.github.io/create-react-app/docs/running-tests) for more information.

### `yarn build`

Builds the app for production to the `build` folder.\
It correctly bundles React in production mode and optimizes the build for the best performance.

The build is minified and the filenames include the hashes.\
Your app is ready to be deployed!

See the section about [deployment](https://facebook.github.io/create-react-app/docs/deployment) for more information.

### `yarn eject`

**Note: this is a one-way operation. Once you `eject`, you can't go back!**

If you aren't satisfied with the build tool and configuration choices, you can `eject` at any time. This command will remove the single build dependency from your project.

Instead, it will copy all the configuration files and the transitive dependencies (webpack, Babel, ESLint, etc) right into your project so you have full control over them. All of the commands except `eject` will still work, but they will point to the copied scripts so you can tweak them. At this point you're on your own.

You don't have to ever use `eject`. The curated feature set is suitable for small and middle deployments, and you shouldn't feel obligated to use this feature. However we understand that this tool wouldn't be useful if you couldn't customize it when you are ready for it.

## Learn More

You can learn more in the [Create React App documentation](https://facebook.github.io/create-react-app/docs/getting-started).

To learn React, check out the [React documentation](https://reactjs.org/).

### Code Splitting

This section has moved here: [https://facebook.github.io/create-react-app/docs/code-splitting](https://facebook.github.io/create-react-app/docs/code-splitting)

### Analyzing the Bundle Size

This section has moved here: [https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size](https://facebook.github.io/create-react-app/docs/analyzing-the-bundle-size)

### Making a Progressive Web App

This section has moved here: [https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app](https://facebook.github.io/create-react-app/docs/making-a-progressive-web-app)

### Advanced Configuration

This section has moved here: [https://facebook.github.io/create-react-app/docs/advanced-configuration](https://facebook.github.io/create-react-app/docs/advanced-configuration)

### Deployment

This section has moved here: [https://facebook.github.io/create-react-app/docs/deployment](https://facebook.github.io/create-react-app/docs/deployment)

### `yarn build` fails to minify

This section has moved here: [https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify](https://facebook.github.io/create-react-app/docs/troubleshooting#npm-run-build-fails-to-minify)
