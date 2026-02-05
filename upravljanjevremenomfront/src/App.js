import logo from './logo.svg';
import './App.css';
import { BrowserRouter, Routes, Route} from 'react-router-dom'
import Pocetna from './pages/Pocetna';
import { LoginPage } from './pages/LoginPage';
import Navbar from './components/Navbar';

function App() {
  return (
    <div>
      <BrowserRouter>
      <Navbar></Navbar>
        <Routes>
          <Route path="/" element={<Pocetna />} />
          <Route path="/login" element={<LoginPage />} />


          {/*<Route path="/" element={<HomePage />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/register" element={<RegisterPage />} />
          */}

        </Routes>
      </BrowserRouter>
      
    </div>
  );
}

export default App;
