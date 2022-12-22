# Tjekind IoT cloudserver and frontend app

As a fun side project i opted to ask tryout ChatGPT

## Question
tell me how to make a php backend and react typescript frontend app to handle and show output from IoT sensors

## Answer
This is the unedited answer from the AI

Sure! Here is a high-level overview of how you can create a PHP backend and a React TypeScript frontend app to handle and display output from IoT sensors:

First, you'll need to set up a server to host your PHP backend. This can be done using a web hosting service or by setting up your own server using tools like Apache or Nginx.

Next, you'll need to install PHP on your server and create a basic PHP script that connects to a database and retrieves data from it. You can use a framework like Laravel or CodeIgniter to make this process easier and more efficient.

To retrieve data from your IoT sensors, you'll need to create a way for them to communicate with your backend. This can be done using a variety of methods, such as HTTP requests, MQTT, or a custom API.

Once you've set up your backend to receive data from your sensors, you can create a React TypeScript frontend app to display this data to users. To do this, you'll need to set up a development environment on your local machine, which will include installing Node.js and the React framework.

To create your React app, you'll need to use a tool like create-react-app to set up the basic structure of your app. From there, you can use TypeScript and React components to build out the user interface and logic for displaying the data from your sensors.

Finally, you'll need to deploy your frontend app to a hosting service or your own server so that users can access it. You can use tools like Git and GitHub to manage your code and make it easier to deploy updates.

I hope this gives you a good overview of the steps involved in creating a PHP backend and React TypeScript frontend app to handle and display data from IoT sensors. Let me know if you have any specific questions or need more guidance on any of these steps!

### A second response from the AI

Sure! Here is a general outline of how you can create a PHP backend and a React frontend app to handle and display data from IoT sensors:

First, you'll need to set up your development environment. This will involve installing a web server (such as Apache or Nginx), a database (such as MySQL), and a programming language (such as PHP). You'll also need to install Node.js and a package manager (such as npm) to set up your React frontend.

Next, you'll need to set up your PHP backend. This will involve creating a database and connecting to it from your PHP code. You'll also need to create a PHP script that receives data from your IoT sensors and stores it in the database.

Next, you'll need to set up your React frontend. This will involve creating a new React app using the create-react-app command and installing any necessary dependencies. You'll also need to create a component that fetches data from your PHP backend and displays it on the page.

Finally, you'll need to connect your frontend and backend. This will involve setting up routes in your PHP backend to handle requests from your React frontend, and using JavaScript fetch or a library like Axios to send HTTP requests from your frontend to your backend.

I hope this helps! Let me know if you have any questions.








# Frontend

I´ve dicided to us yarn as pacage manager - i just like it better than npm<br/>
Ref: Home | Yarn - Package Manager https://yarnpkg.com

## Setting up React with typescript
a vanilla React TypeScript app
    yarn create react-app tjekind-app

Add typescript:
    yarn add typescript @types/node @types/react @types/react-dom @types/jest

Now let’s upgrade the version of React to @next:
    yarn global add react@next react-dom@next

If you´re not familiar with typescriptlook at:
https://www.typescriptlang.org/

Since im using a backend platform of php i don´t think GraphQL will be necessary

# Files
insert.php