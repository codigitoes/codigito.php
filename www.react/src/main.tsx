import React from 'react'
import ReactDOM from 'react-dom/client'
import './index.css'
import ThemeConfig from './config/theme.config.tsx'
import App from './components/app/App.tsx'

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <ThemeConfig>
      <App />
    </ThemeConfig>
  </React.StrictMode>,
)
