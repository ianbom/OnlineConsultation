import path from "path";

export default ({ file }) => {
  const isReact = file?.dirname?.includes(path.join("resources", "js"));

  return {
    plugins: {
      tailwindcss: isReact
        ? "./tailwind.react.config.js"
        : "./tailwind.config.js",
      autoprefixer: {},
    },
  };
};
