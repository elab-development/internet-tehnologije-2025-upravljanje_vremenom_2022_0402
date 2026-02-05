import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import { useState } from "react";

import Pocetna from "./pages/Pocetna";
import LoginPage from "./pages/LoginPage";
import Beleske from "./pages/Beleske";
import Zadatak from "./pages/Zadatak";
import Podsetnik from "./pages/Podsetnik";
import Obavestenje from "./pages/Obavestenje";
import Statistika from "./pages/Statistika";

import Navbar from "./components/Navbar";

function App() {
  const [user, setUser] = useState(null);

  const handleLogin = (email) => setUser({ email });

  const ProtectedRoute = ({ children }) => {
    if (!user) return <Navigate to="/login" />;
    return children;
  };

  return (
    <Router>
      
      {user && <Navbar user={user} onLogout={() => setUser(null)} />}

      <Routes>
        <Route path="/login" element={<LoginPage onLogin={handleLogin} />} />

        <Route
          path="/home"
          element={
            <ProtectedRoute>
              <Pocetna />
            </ProtectedRoute>
          }
        />
        <Route
          path="/beleske"
          element={
            <ProtectedRoute>
              <Beleske />
            </ProtectedRoute>
          }
        />
        <Route
          path="/zadaci"
          element={
            <ProtectedRoute>
              <Zadatak />
            </ProtectedRoute>
          }
        />
        <Route
          path="/podsetnik"
          element={
            <ProtectedRoute>
              <Podsetnik />
            </ProtectedRoute>
          }
        />
        <Route
          path="/obavestenja"
          element={
            <ProtectedRoute>
              <Obavestenje />
            </ProtectedRoute>
          }
        />
        <Route
          path="/statistika"
          element={
            <ProtectedRoute>
              <Statistika />
            </ProtectedRoute>
          }
        />

        {/* fallback ruta */}
        <Route path="*" element={<Navigate to={user ? "/home" : "/login"} />} />
      </Routes>
    </Router>
  );
}

export default App;
