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
          <Route path="/home" element={<Pocetna />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/beleske" element={<Beleske />} />
          <Route path="/podsetnik" element={<Podsetnik />} />
          <Route path="/zadaci" element={<Zadatak />} />
          <Route path="/obavestenja" element={<Obavestenje />} />
          <Route path="/statistika" element={<Statistika />} />

          

        </Routes>
      </BrowserRouter>
      
    </div>
  );
}

export default App;
