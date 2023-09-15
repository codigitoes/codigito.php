import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import BlogPage from '../pages/blog/BlogPage';
import BlogpostPage from '../pages/blogpost/BlogpostPage';
import HomePage from '../pages/home/HomePage';
import LoginPage from '../pages/login/LoginPage';
import RegisterPage from '../pages/register/RegisterPage';
import '../styles/global.scss';
import { Layout } from './Layout';
import SettingsPage from '../pages/settings/SettingsPage';

const router = createBrowserRouter([
  {
    path: "/",
    element: <Layout />,
    children: [
      {
        path: "/settings",
        element: <SettingsPage />
      },
      {
        path: "/logout",
        element: <LoginPage />
      },
      {
        path: "/",
        element: <HomePage />
      },
      {
        path: "/blogposts",
        element: <BlogPage />
      },
      {
        path: "/blogposts/:id",
        element: <BlogpostPage />
      },
      {
        path: "/blogposts/tag/:tag",
        element: <BlogPage />
      },
      {
        path: "/blogposts",
        element: <BlogPage />
      }]
  },
  {
    path: "/login",
    element: <LoginPage />
  },
  {
    path: "/register",
    element: <RegisterPage />
  }
]);

const AppRouterProvider: React.FC<{}> = () => {

  return <RouterProvider router={router} />
};

export default AppRouterProvider;

