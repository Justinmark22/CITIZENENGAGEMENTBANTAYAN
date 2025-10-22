import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './app';  // Import your App component

const container = document.getElementById('root');
const root = createRoot(container);
root.render(<App />);
