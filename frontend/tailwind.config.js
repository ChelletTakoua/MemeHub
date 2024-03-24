module.exports = {
  content: ["./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Karla", "sans-serif"],
        mono: ["Oswald", "sans-serif"],
      },
      letterSpacing: {
        tightest: "-.1em",
      },
      colors: {
        greens:{
          100: "#039A8C",
          200: "#12A08B",
        },
        nightgreen: "#2C6957",
        algae: "#00998D",
        grass: "#9EDE7B",
        palenight: "#164e63",
      },
    },
  },
  plugins: [],
};
