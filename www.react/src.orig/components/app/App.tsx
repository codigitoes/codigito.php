import './App.css';
import { BrowserRouter } from 'react-router-dom';
import AppRouter from './AppRouter';

const App: React.FC<unknown> = () => {
  return (
      <BrowserRouter>
        <AppRouter />
      </BrowserRouter>
  )
} 

export default App;
