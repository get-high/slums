/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//import './styles/app.css';

// start the Stimulus application
//import './bootstrap';

import React, {StrictMode} from 'react'
import {createRoot} from "react-dom/client";

class App extends React.Component {
    render() {
        return (
            <div>Hello From React</div>
        );
    }
}

const root = document.getElementById('root');
const app = createRoot(root);

app.render(
    <StrictMode>
        <App/>
    </StrictMode>,
);