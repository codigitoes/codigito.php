import { Outlet, RouterProvider, createBrowserRouter } from "react-router-dom"
import HomePage from "./pages/home/HomePage"
import BlogPage from "./pages/blog/BlogPage";
import Navbar from "./components/navbar/Navbar";
import Footer from "./components/footer/Footer";
import Menu from "./components/menu/Menu";
import LoginPage from "./pages/login/LoginPage";
import './styles/global.scss';
import BlogpostPage from "./pages/blogpost/BlogpostPage";

const App: React.FC<{}> = ({ }) => {

  const Layout = () => {
    return (
      <div className="main">
        <Navbar />
        <div className="container">
          <div className="menuContainer">
            <Menu />
          </div>
          <div className="contentContainer">
            <Outlet />
          </div>
        </div>
        <Footer />
      </div >
    );
  }

  const router = createBrowserRouter([
    {
      path: "/",
      element: <Layout />,
      children: [
        {
          path: "/",
          element: <HomePage />
        },
        {
          path: "/blog",
          element: <BlogPage />
        },
        {
          path: "/blogpost/:id",
          element: <BlogpostPage />
        }]
    },
    {
      path: "/login",
      element: <LoginPage />
    }
  ]);

  return (
    <RouterProvider router={router} />
  )
}

export default App
