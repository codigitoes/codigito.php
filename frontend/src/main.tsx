import React from 'react'
import ReactDOM from 'react-dom/client'
import { App } from './components/App'
import TagsProvider from './components/TagsProvider'


ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <React.StrictMode>
    <TagsProvider>
      <App />
    </TagsProvider>
  </React.StrictMode>,
)
