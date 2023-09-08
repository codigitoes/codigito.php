import { ThemeProvider } from '@emotion/react';
import { CssBaseline } from '@mui/material';
import * as React from 'react';
import * as ReactDOM from 'react-dom/client';
import theme from './theme';
import { BrowserRouter } from 'react-router-dom';
import Dashboard from './dashboard/Dashboard';

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <React.StrictMode>
    <ThemeProvider theme={theme}>
      <BrowserRouter>
        <CssBaseline />
        <Dashboard />
      </BrowserRouter>
    </ThemeProvider>
  </React.StrictMode>,
);
