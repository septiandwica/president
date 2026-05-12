import js from "@eslint/js";

export default [
  {
    languageOptions: {
      ecmaVersion: "latest",   // pakai "latest" bukan angka
      sourceType: "module",
      globals: {
        require:   "readonly",
        module:    "readonly",
        process:   "readonly",
        define:    "readonly",
        window:    "readonly",
        document:  "readonly",
        Y:         "readonly",  // Moodle YUI
        M:         "readonly",  // Moodle global
      }
    },
    rules: {
      "no-undef": "error",
      "camelcase": "error"
    }
  }
];