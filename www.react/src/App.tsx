import './App.css';
import NavBar from './components/common/NavBar';
import { BrowserRouter } from 'react-router-dom';
import AppRouter from './components/AppRouter';

function App() {
  return (
    <BrowserRouter>
      <AppRouter />
      <NavBar/>
    </BrowserRouter>
  )
} 

export default App;
